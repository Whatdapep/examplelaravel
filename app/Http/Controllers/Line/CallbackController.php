<?php

namespace App\Http\Controllers\Line;


use App\Http\Controllers\Controller;
// use App\LINE\EventHandler\MessageHandler\AudioMessageHandler;
// use App\LINE\EventHandler\MessageHandler\ImageMessageHandler;
// use App\LINE\EventHandler\MessageHandler\LocationMessageHandler;
// use App\LINE\EventHandler\MessageHandler\StickerMessageHandler;
use App\LINE\EventHandler\MessageHandler\TextMessageHandler;
// use App\LINE\EventHandler\MessageHandler\VideoMessageHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
// use App\Line\linetiny as bot;
use App\Line\LINE_CONFIG;
// LINE SDK  -----------------------
use LINE\LINEBot\Constant\HTTPHeader;
use LINE\LINEBot\Event\MessageEvent;
use LINE\LINEBot\Exception\InvalidEventRequestException;
use LINE\LINEBot\Exception\InvalidSignatureException;

// use LINE\LINEBot\Event\MessageEvent\AudioMessage;
// use LINE\LINEBot\Event\MessageEvent\ImageMessage;
// use LINE\LINEBot\Event\MessageEvent\LocationMessage;
// use LINE\LINEBot\Event\MessageEvent\StickerMessage;
use LINE\LINEBot\Event\MessageEvent\TextMessage;
use LINE\LINEBot\Event\MessageEvent\UnknownMessage;

// use LINE\LINEBot\Event\MessageEvent\VideoMessage;

class CallbackController extends Controller
{
    //
    public function Webhook(Request $request)
    {
        $channelAccessToken = config('line.LINEBOT_CHANNEL_TOKEN');
        $channelSecret = config('line.LINEBOT_CHANNEL_SECRET');

        file_put_contents('LINE/logs/log.txt', json_encode($request->json()->all(), JSON_UNESCAPED_UNICODE) . PHP_EOL, FILE_APPEND);
        $keep_log = json_encode($request->json()->all(), JSON_UNESCAPED_UNICODE);
        // -------------------------------------------------------------------------------------------
        /** @var \LINE\LINEBot $bot */
        $bot = LINE_CONFIG::config();
        // --------------------------------------------------------------------------------
        $signature = $request->header(HTTPHeader::LINE_SIGNATURE);
        // -------------------------------------------------------------------------------------
        try {
            $events = $bot->parseEventRequest(json_encode($request->json()->all(), JSON_UNESCAPED_UNICODE), $signature);
        } catch (InvalidSignatureException $e) {
            return response('Invalid signature', 400);
        } catch (InvalidEventRequestException $e) {
            return response("Invalid event request", 400);
        }

        foreach ($events as $event) {
            $logger = '';

            if ($event instanceof MessageEvent) {

                // $event_type = 'message';
                // $message_type = $event->getMessageType();
                // $replToken = $event->getReplyToken();
                // $userId = $event->getUserId();

                if ($event instanceof TextMessage) {
                    $handler = new TextMessageHandler($bot, $logger, $request->json()->all(), $event);
                    // $data = $event->getText();
                }
                // elseif ($event instanceof StickerMessage) {
                //     $handler = new StickerMessageHandler($bot, $logger, $event);
                //     $obj = array("packageId"=>$event->getPackageId(),"stickerId"=>$event->getStickerId());
                //     $data = json_encode($obj,JSON_UNESCAPED_UNICODE);

                // } elseif ($event instanceof LocationMessage) {
                //     $handler = new LocationMessageHandler($bot, $logger, $event);
                //     $obj= array("title"=>$event->getTitle(),"address"=>$event->getAddress(),
                //     "latitude"=>$event->getLatitude(),"longitude"=>$event->getLongitude());
                //     $data = json_encode($obj,JSON_UNESCAPED_UNICODE);
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


            $handler->handle();
        }
        return Response('Hello World', 200);
    }
}
