<?php

declare(strict_types=1);

namespace api\services\request;

use api\dto\processor\request\StartProcessorDto;
use api\dto\processor\response\ProcessorSuccessDto;
use api\dto\request\request\CreateRequestDto;
use api\dto\request\response\RequestDto;
use api\enum\request\RequestStatusEnum;
use common\models\Request\Repository\RequestRepository;
use common\models\User\Repository\UserRepository;
use Exception;
use Yii;
use yii\db\Transaction;

class RequestService
{
    private RequestRepository $requestRepository;
    private UserRepository $userRepository;

    public function __construct(RequestRepository $requestRepository, UserRepository $userRepository)
    {
        $this->requestRepository = $requestRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param  CreateRequestDto  $dto
     * @return RequestDto
     * @throws Exception
     */
    public function saveRequest(CreateRequestDto $dto): RequestDto
    {
        $request = $this->requestRepository->create(
            [
                'user_id' => $dto->getUserId(),
                'amount' => $dto->getAmount(),
                'term' => $dto->getTerm(),
            ]
        );

        return new RequestDto(true, $request->getId());
    }

    /**
     * @param  StartProcessorDto  $dto
     * @return ProcessorSuccessDto
     * @throws Exception
     */
    public function startProcess(StartProcessorDto $dto): ProcessorSuccessDto
    {
        $allWaitingRequests = $this->requestRepository->getAllWaitingRequests();

        foreach ($allWaitingRequests as $waitingRequest) {
            try {
                $transaction = Yii::$app->db->beginTransaction();
                $transaction->setIsolationLevel(Transaction::READ_UNCOMMITTED);
                $user = $waitingRequest->user;
                if ($this->userRepository->hasApprovedRequest($user->id)) {
                    $this->requestRepository->updateOneById($waitingRequest->id, ['status' => RequestStatusEnum::DECLINED]);
                    $transaction->commit();
                    continue;
                }
                $status = $this->isApprove() ? RequestStatusEnum::APPROVED : RequestStatusEnum::DECLINED;
                $this->requestRepository->updateOneById($waitingRequest->id, ['status' => $status]);
                $transaction->commit();

                sleep($dto->getDelay());
            } catch (\Throwable $exception) {
                continue;
            }
        }

        return new ProcessorSuccessDto();
    }

    /**
     * @param  int  $percent
     * @return bool
     */
    private function isApprove(int $percent = 10): bool
    {
        return mt_rand(0, 99) < $percent;
    }
}