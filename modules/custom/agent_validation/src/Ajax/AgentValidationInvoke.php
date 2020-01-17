<?php
namespace Drupal\agent_validation\Ajax;
use Drupal\Core\Ajax\CommandInterface;

class AgentValidationInvoke implements CommandInterface
{
    public function render(){
        return [
            'command' => 'agentValidationInvoke',
        ];
    }

}