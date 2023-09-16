<?php
namespace Orchestrators;

use SDPMlab\Anser\Orchestration\Orchestrator;
use Services\UserService;
class UserLoginOrchestrator extends Orchestrator
{
    protected $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    protected function definition(string $email = "", string $password = "")
    {
        $this->setStep()
            ->addAction('login', $this->userService->userLoginAction($email, $password));
        $this->setStep()
            ->addAction('info', static function(UserLoginOrchestrator $runtimeOrch){
                $data = $runtimeOrch->getStepAction('login')->getMeaningData();
                return $runtimeOrch->userService->userInfoAction($data['token']);
            });
        $this->setStep()
            ->addAction('wallet', static function(UserLoginOrchestrator $runtimeOrch){
                $data = $runtimeOrch->getStepAction('info')->getMeaningData();
                return $runtimeOrch->userService->walletAction($data['data']['u_key']);
            });
    }

    protected function defineResult(): array
    {        
        $data = [
            "token" => $this->getStepAction('login')->getMeaningData()['token'],
            "userData" => $this->getStepAction('info')->getMeaningData()['data'],
            "walletInfo" => $this->getStepAction('wallet')->getMeaningData()['data']
        ];
        return $data;
    }

}
