<?php

namespace App\Http\Controllers\LINE;

use App\Http\Controllers\Controller;
use App\LINE\Config;
use App\Line\EventHandler\MessageHandler\AudioMessageHandler;
use App\Line\EventHandler\MessageHandler\ImageMessageHandler;
use App\Line\EventHandler\MessageHandler\LocationMessageHandler;
use App\Line\EventHandler\MessageHandler\StickerMessageHandler;
use App\LINE\EventHandler\MessageHandler\TextMessageHandler;
use App\Line\EventHandler\MessageHandler\VideoMessageHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
// use App\Line\linetiny as bot;
use App\Line\LINE_CONFIG;
// LINE SDK  -----------------------
use LINE\LINEBot\Constant\HTTPHeader;
use LINE\LINEBot\Event\MessageEvent;
use LINE\LINEBot\Exception\InvalidEventRequestException;
use LINE\LINEBot\Exception\InvalidSignatureException;
// ---------------------------
// use Slim\Http\Request as slim_request;
// use Slim\Http\Response as slim_response;


// use App\Model\Api\Line\line_active_logs;
use LINE\LINEBot\Event\MessageEvent\AudioMessage;
use LINE\LINEBot\Event\MessageEvent\ImageMessage;
use LINE\LINEBot\Event\MessageEvent\LocationMessage;
use LINE\LINEBot\Event\MessageEvent\StickerMessage;
use LINE\LINEBot\Event\MessageEvent\TextMessage;
use LINE\LINEBot\Event\MessageEvent\UnknownMessage;
use LINE\LINEBot\Event\MessageEvent\VideoMessage;

class CallbackController extends Controller
{
    public function index(Request $request)
    // public function index(slim_request $req)
    {
        $channelAccessToken = config('line.LINEBOT_CHANNEL_TOKEN');
        $channelSecret = config('line.LINEBOT_CHANNEL_SECRET');
        // file_put_contents('LINE/logs/log.txt', json_encode($request->json()->all(), JSON_UNESCAPED_UNICODE) . PHP_EOL, FILE_APPEND);
        // $keep_log = json_encode($request->json()->all(),JSON_UNESCAPED_UNICODE);
        // -------------------------------------------------------------------------------------------
        /** @var \LINE\LINEBot $bot */
        $bot = Config::config();
        // --------------------------------------------------------------------------------
        $signature = $request->header(HTTPHeader::LINE_SIGNATURE);
        // $signature = $request->hasHeader(HTTPHeader::LINE_SIGNATURE);
        if (empty($signature)) {
            return Response('Bad Request', 400);
        }
        // file_put_contents('LINE/logs/log.txt', json_encode($request->json()->all(), JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES), FILE_APPEND);
        // -------------------------------------------------------------------------------------
        try {
            $events = $bot->parseEventRequest(json_encode($request->json()->all(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), $signature);
        } catch (InvalidSignatureException $e) {
            return response('Invalid signature', 400);
        } catch (InvalidEventRequestException $e) {
            return response("Invalid event request", 400);
        }
        // file_put_contents('LINE/logs/log.txt', json_encode($request->json()->all(), JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) . PHP_EOL, FILE_APPEND);
        foreach ($events as $event) {
            $logger = '';
            if ($event instanceof MessageEvent) {
                $event_type = 'message';
                $message_type = $event->getMessageType();
                $replToken = $event->getReplyToken();
                $userId = $event->getUserId();
                // file_put_contents('LINE/logs/log.txt', json_encode($request->json()->all(), JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES), FILE_APPEND);
                // file_put_contents('LINE/logs/log.txt', json_encode(array('replToken'=>$replToken) ,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES), FILE_APPEND);
                if ($event instanceof TextMessage) {
                    file_put_contents('LINE/logs/log.txt', json_encode(array('first' => '1', 'replToken' => $replToken, 'message_type' => $message_type, 'bot' => $bot, 'json' => $request->json()->all()), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), FILE_APPEND);

                    $replyText = $event->getText();

                    $resp = $bot->replyText($event->getReplyToken(), $replyText);
                    // $handler = new TextMessageHandler($bot, $logger, $request->json()->all(), $event);
                    file_put_contents('LINE/logs/log.txt', json_encode(array('replToken' => $replToken, 'message_type' => $message_type, 'handler' => $handler), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), FILE_APPEND);
                    $data = $event->getText();
                }
                // elseif ($event instanceof StickerMessage) {
                //     $handler = new StickerMessageHandler($bot, $logger, $event);
                //     $obj = array("packageId" => $event->getPackageId(), "stickerId" => $event->getStickerId());
                //     $data = json_encode($obj, JSON_UNESCAPED_UNICODE);
                // } elseif ($event instanceof LocationMessage) {
                //     $handler = new LocationMessageHandler($bot, $logger, $event);
                //     $obj = array(
                //         "title" => $event->getTitle(), "address" => $event->getAddress(),
                //         "latitude" => $event->getLatitude(), "longitude" => $event->getLongitude()
                //     );
                //     $data = json_encode($obj, JSON_UNESCAPED_UNICODE);
                // } elseif ($event instanceof ImageMessage) {
                //     $handler = new ImageMessageHandler($bot, $logger, $request->json()->all(), $event);
                //     $data = '';
                // } elseif ($event instanceof AudioMessage) {
                //     $handler = new AudioMessageHandler($bot, $logger, $request->json()->all(), $event);
                // } elseif ($event instanceof VideoMessage) {
                //     $handler = new VideoMessageHandler($bot, $logger, $request->json()->all(), $event);
                // }
                elseif ($event instanceof UnknownMessage) {
                    // $logger->info(sprintf(
                    //     'Unknown message type has come [message type: %s]',
                    //     $event->getMessageType()
                    // ));
                } else {
                    // Unexpected behavior (just in case)
                    // something wrong if reach here

                    // $logger->info(sprintf(
                    //     'Unexpected message type has come, something wrong [class name: %s]',
                    //     get_class($event)
                    // ));
                    continue;
                }
            }
            // $save_logs = new line_active_logs;
            // $save_logs->event_type = $event_type;
            // $save_logs->replyToken = $replToken;
            // $save_logs->userId = $userId;
            // $save_logs->message_type = $message_type;
            // $save_logs->message = $data;
            // $save_logs->keep_logs = $keep_log;
            // $save_logs->save();

            // $handler->handle();
        }
        return Response('Hello World', 200);
    }
}
