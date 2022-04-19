<?php


namespace App\Http\Controllers\Api\V1\Employee\Message;


use App\EMS\Employee\Employee;
use App\EMS\Message\Message;
use App\EMS\MessageConversation\MessageConversation;
use App\Http\Controllers\Api\V1\Employee\EmployeeBaseController;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class MessageController extends EmployeeBaseController
{
    public function index(Request $request)
    {
        try {
            $limit = $request->input('limit', 10);
            $offset = $request->input('offset', 0);


            $employee = $this->user();
            $messages = Message::query()
                ->where('employee_one_id', $employee->id)
                ->orWhere('employee_two_id', $employee->id);

            $total = $messages->count();

            if ($total > 0){
                $messages = $messages->limit($limit)->offset($offset)->orderByDesc('updated_at')->get();
                return $this->success(['messages' => $messages, 'total' => $total]);
            }else{
                return $this->success(['messages' => 0, 'total' => 0]);
            }
        }catch (\Exception $exception){
            return $this->failed("Unknown Failure");
        }
    }

    public function newMessage(Request $request)
    {
        $request->validate([
            'employee_one_id' => 'required',
            'employee_two_id' => 'required'
        ]);
        try {

            $employeeOneId = $request->input('employee_one_id');
            $employeeTwoId = $request->input('employee_two_id');

            if ($employeeOneId === $employeeTwoId){
                return $this->failed("You can't message your self");
            }
            $employees = Employee::query()->whereIn('id', [$employeeTwoId, $employeeOneId])->get();
            if (count($employees) < 2){
                return $this->failed("Employee you want to chat with does not exist");
            }
            $ChattedOne = Message::query()->where('employee_one_id', $employeeOneId)->where('employee_two_id', $employeeTwoId)->first();
            $ChattedTwo = Message::query()->where('employee_one_id', $employeeTwoId)->where('employee_two_id', $employeeOneId)->first();

            $message = $ChattedOne??$ChattedTwo;
            if ($message){
               return $this->success(['message' => $message]);
            }else{
                $message = Message::query()->create([
                    'employee_one_id' => $employeeOneId,
                    'employee_two_id' => $employeeTwoId
                ]);
                return $this->success(['message' => $message]);
            }
        }catch (\Exception $exception){
            return $this->failed("Unknown Failure");
        }
    }

    public function conversations(Request $request)
    {
        $request->validate([
            'message_id' => 'required'
        ]);

        try {

            $limit = $request->input('limit', 10);
            $offset = $request->input('offset', 0);

            $messageId = $request->input('message_id');

            $conversations = MessageConversation::query()->with([
                'messageBody', 'sender'
            ])->where('message_id', $messageId);
            $total = $conversations->count()??0;
            if ($total > 0){
                $conversations = $conversations->limit($limit)->offset($offset)
                    ->orderByDesc('created_at')->get();
                return $this->success([
                    'conversations' => $conversations,
                    'total' => $total
                ]);
            }else{
                return $this->success([
                    'conversations' => [],
                    'total' => 0
                ]);
            }

        }catch (\Exception $exception){
            return $this->failed("Unknown Failure");
        }
    }

    public function newConversation(Request $request)
    {
        try {
            $request->validate([
                'message_id' => 'required',
                'chat_employee_id' => 'required'
            ]);

            $messageId = $request->input('message_id');
            $employeeId = $request->input('chat_employee_id');

            $message = $request->input('message');
            $attachment = $request->input('attachment');

            if (!$message && !$attachment){
                return $this->forbidden("Empty message can not be sent on the channel");
            }
            $conversation = MessageConversation::query()->create([
                'chat_employee_id' => $employeeId,
                'message_id' => $messageId,
                'message' => $message,
                'is_read' => 0
            ]);
            if ($conversation){
                Message::query()->where('id', $messageId)->first()->update([
                    'time' => time()
                ]);
                if ($attachment){
                    $this->storeMediaFiles($conversation, $attachment, 'attachment');
                }
                return $this->success([
                    'conversation' => $conversation->load('sender','messageBody')
                ]);
            }
        }catch (\Exception $exception){
            return $this->failed("Unknown Failure");
        }
    }
}
