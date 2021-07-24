<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/choi-voi-nhau', function () {
    return view('human', ['headTitle' => 'Chơi với nhau', 'bodyClass' => 'home', 'roomCode' => '', 'langUrl' => '/en']);
});
Route::get('/play-with-friend', function () {
    return view('en/human', ['headTitle' => 'Play with friend', 'bodyClass' => 'home', 'roomCode' => '', 'langUrl' => '/']);
});

Route::get('/ban-co/{fen}', function ($fen) {
  return view('board', ['headTitle' => 'Bàn cờ', 'bodyClass' => 'home', 'fen' => $fen, 'roomCode' => '', 'langUrl' => '/board/'.$fen]);
})->where(['fen' => "[a-zA-Z0-9\-\/\s|&nbsp;]+"]);

Route::get('/ban-co-de-nhat/{fen}', function ($fen) {
  return view('boardAi', ['headTitle' => 'Bàn cờ dễ nhất', 'bodyClass' => 'home', 'fen' => $fen, 'roomCode' => '', 'level' => '1', 'levelTxt' => 'Dễ nhất', 'langUrl' => '/easiest-board/'.$fen, 'canonicalUrl' => '/ban-co-de-nhat/'.$fen]);
})->where(['fen' => "[a-zA-Z0-9\-\/\s|&nbsp;]+"]);
Route::get('/ban-co-moi-choi/{fen}', function ($fen) {
  return view('boardAi', ['headTitle' => 'Bàn cờ mới chơi', 'bodyClass' => 'home', 'fen' => $fen, 'roomCode' => '', 'level' => '1', 'levelTxt' => 'Mới chơi', 'langUrl' => '/newbie-board/'.$fen, 'canonicalUrl' => '/ban-co-moi-choi/'.$fen]);
})->where(['fen' => "[a-zA-Z0-9\-\/\s|&nbsp;]+"]);
Route::get('/ban-co-de/{fen}', function ($fen) {
  return view('boardAi', ['headTitle' => 'Bàn cờ dễ', 'bodyClass' => 'home', 'fen' => $fen, 'roomCode' => '', 'level' => '2', 'levelTxt' => 'Dễ', 'langUrl' => '/easy-board/'.$fen, 'canonicalUrl' => '/ban-co-de/'.$fen]);
})->where(['fen' => "[a-zA-Z0-9\-\/\s|&nbsp;]+"]);
Route::get('/ban-co-binh-thuong/{fen}', function ($fen) {
  return view('boardAi', ['headTitle' => 'Bàn cờ bình thường', 'bodyClass' => 'home', 'fen' => $fen, 'roomCode' => '', 'level' => '3', 'levelTxt' => 'Bình thường', 'langUrl' => '/normal-board/'.$fen, 'canonicalUrl' => '/ban-co-binh-thuong/'.$fen]);
})->where(['fen' => "[a-zA-Z0-9\-\/\s|&nbsp;]+"]);
Route::get('/ban-co-kho/{fen}', function ($fen) {
  return view('boardAi', ['headTitle' => 'Bàn cờ khó', 'bodyClass' => 'home', 'fen' => $fen, 'roomCode' => '', 'level' => '4', 'levelTxt' => 'Khó', 'langUrl' => '/hard-board/'.$fen, 'canonicalUrl' => '/ban-co-kho/'.$fen]);
})->where(['fen' => "[a-zA-Z0-9\-\/\s|&nbsp;]+"]);
Route::get('/ban-co-kho-nhat/{fen}', function ($fen) {
  return view('boardAi', ['headTitle' => 'Bàn cờ khó nhất', 'bodyClass' => 'home', 'fen' => $fen, 'roomCode' => '', 'level' => '5', 'levelTxt' => 'Khó nhất', 'langUrl' => '/hardest-board/'.$fen, 'canonicalUrl' => '/ban-co-kho-nhat/'.$fen]);
})->where(['fen' => "[a-zA-Z0-9\-\/\s|&nbsp;]+"]);

Route::get('/board/{fen}', function ($fen) {
    return view('en/board', ['headTitle' => 'Board', 'bodyClass' => 'home', 'fen' => $fen, 'roomCode' => '', 'langUrl' => '/ban-co/'.$fen]);
})->where(['fen' => "[a-zA-Z0-9\-\/\s|&nbsp;]+"]);

Route::get('/easiest-board/{fen}', function ($fen) {
    return view('en/boardAi', ['headTitle' => 'Easiest board', 'bodyClass' => 'home', 'fen' => $fen, 'roomCode' => '', 'level' => '1', 'levelTxt' => 'Easiest', 'langUrl' => '/ban-co-de-nhat/'.$fen, 'canonicalUrl' => '/easiest-board/'.$fen]);
})->where(['fen' => "[a-zA-Z0-9\-\/\s|&nbsp;]+"]);
Route::get('/newbie-board/{fen}', function ($fen) {
    return view('en/boardAi', ['headTitle' => 'Newbie board', 'bodyClass' => 'home', 'fen' => $fen, 'roomCode' => '', 'level' => '1', 'levelTxt' => 'Newbie', 'langUrl' => '/ban-co-de-nhat/'.$fen, 'canonicalUrl' => '/newbie-board/'.$fen]);
})->where(['fen' => "[a-zA-Z0-9\-\/\s|&nbsp;]+"]);
Route::get('/easy-board/{fen}', function ($fen) {
    return view('en/boardAi', ['headTitle' => 'Easy board', 'bodyClass' => 'home', 'fen' => $fen, 'roomCode' => '', 'level' => '2', 'levelTxt' => 'Easy', 'langUrl' => '/ban-co-de/'.$fen, 'canonicalUrl' => '/easy-board/'.$fen]);
})->where(['fen' => "[a-zA-Z0-9\-\/\s|&nbsp;]+"]);
Route::get('/normal-board/{fen}', function ($fen) {
    return view('en/boardAi', ['headTitle' => 'Normal board', 'bodyClass' => 'home', 'fen' => $fen, 'roomCode' => '', 'level' => '3', 'levelTxt' => 'Normal', 'langUrl' => '/ban-co-binh-thuong/'.$fen, 'canonicalUrl' => '/normal-board/'.$fen]);
})->where(['fen' => "[a-zA-Z0-9\-\/\s|&nbsp;]+"]);
Route::get('/hard-board/{fen}', function ($fen) {
    return view('en/boardAi', ['headTitle' => 'Hard board', 'bodyClass' => 'home', 'fen' => $fen, 'roomCode' => '', 'level' => '4', 'levelTxt' => 'Hard', 'langUrl' => '/ban-co-kho/'.$fen, 'canonicalUrl' => '/hard-board/'.$fen]);
})->where(['fen' => "[a-zA-Z0-9\-\/\s|&nbsp;]+"]);
Route::get('/hardest-board/{fen}', function ($fen) {
    return view('en/boardAi', ['headTitle' => 'Hardest board', 'bodyClass' => 'home', 'fen' => $fen, 'roomCode' => '', 'level' => '5', 'levelTxt' => 'Hardest', 'langUrl' => '/ban-co-kho-nhat/'.$fen, 'canonicalUrl' => '/hardest-board/'.$fen]);
})->where(['fen' => "[a-zA-Z0-9\-\/\s|&nbsp;]+"]);

Route::get('/xep-co/{board}', function ($board) {
  return view('setup', ['headTitle' => 'Xếp bàn cờ', 'bodyClass' => 'setup', 'board' => $board, 'roomCode' => '', 'langUrl' => '/set-up/'.$board]);
})->where(['board' => "[a-zA-Z0-9\-\/\s|&nbsp;]+"]);
Route::get('/set-up/{board}', function ($board) {
  return view('en/setup', ['headTitle' => 'Set up the board', 'bodyClass' => 'setup', 'board' => $board, 'roomCode' => '', 'langUrl' => '/xep-co/'.$board]);
})->where(['board' => "[a-zA-Z0-9\-\/\s|&nbsp;]+"]);

Route::get('/xep-co', function () {
  return view('setup', ['headTitle' => 'Xếp bàn cờ', 'bodyClass' => 'setup', 'board' => '', 'roomCode' => '', 'langUrl' => '/set-up']);
});
Route::get('/set-up', function () {
  return view('en/setup', ['headTitle' => 'Set up the board', 'bodyClass' => 'setup', 'board' => '', 'roomCode' => '', 'langUrl' => '/xep-co']);
});

Route::get('/', function () {
  return view('ai', ['headTitle' => 'Trang chủ', 'bodyClass' => 'home', 'roomCode' => '', 'langUrl' => '/en', 'level' => '3', 'levelTxt' => 'Bình thường']);
});
Route::get('/de-nhat', function () {
  return view('ai', ['headTitle' => 'Dễ nhất', 'bodyClass' => 'home', 'roomCode' => '', 'langUrl' => '/easiest', 'level' => '1', 'levelTxt' => 'Dễ nhất']);
});
Route::get('/moi-choi', function () {
    return view('ai', ['headTitle' => 'Mới chơi', 'bodyClass' => 'home', 'roomCode' => '', 'langUrl' => '/newbie', 'level' => '1', 'levelTxt' => 'Mới chơi']);
});
Route::get('/de', function () {
  return view('ai', ['headTitle' => 'Dễ', 'bodyClass' => 'home', 'roomCode' => '', 'langUrl' => '/easy', 'level' => '2', 'levelTxt' => 'Dễ']);
});
Route::get('/binh-thuong', function () {
  return view('ai', ['headTitle' => 'Bình thường', 'bodyClass' => 'home', 'roomCode' => '', 'langUrl' => '/normal', 'level' => '3', 'levelTxt' => 'Bình thường']);
});
Route::get('/kho', function () {
  return view('ai', ['headTitle' => 'Khó', 'bodyClass' => 'home', 'roomCode' => '', 'langUrl' => '/hard', 'level' => '4', 'levelTxt' => 'Khó']);
});
Route::get('/kho-nhat', function () {
  return view('ai', ['headTitle' => 'Khó nhất', 'bodyClass' => 'home', 'roomCode' => '', 'langUrl' => '/hardest', 'level' => '5', 'levelTxt' => 'Khó nhất']);
});
Route::get('/choi-voi-may', function () {
  return redirect('/');
});
Route::get('/choi-voi-may/de-nhat', function () {
  return redirect('/de-nhat',);
});
Route::get('/choi-voi-may/moi-choi', function () {
  return redirect('/moi-choi',);
});
Route::get('/choi-voi-may/de', function () {
  return redirect('/de');
});
Route::get('/choi-voi-may/binh-thuong', function () {
  return redirect('/binh-thuong');
});
Route::get('/choi-voi-may/kho', function () {
  return redirect('/kho');
});
Route::get('/choi-voi-may/kho-nhat', function () {
  return redirect('/kho-nhat');
});

Route::get('/en', function () {
  return view('en/ai', ['headTitle' => 'Home', 'bodyClass' => 'home', 'roomCode' => '', 'langUrl' => '/', 'level' => '3', 'levelTxt' => 'Normal']);
});
Route::get('/easiest', function () {
  return view('en/ai', ['headTitle' => 'Easiest', 'bodyClass' => 'home', 'roomCode' => '', 'langUrl' => '/de-nhat', 'level' => '1', 'levelTxt' => 'Easiest']);
});
Route::get('/newbie', function () {
    return view('en/ai', ['headTitle' => 'Newbie', 'bodyClass' => 'home', 'roomCode' => '', 'langUrl' => '/moi-choi', 'level' => '1', 'levelTxt' => 'Newbie']);
});
Route::get('/easy', function () {
  return view('en/ai', ['headTitle' => 'Easy', 'bodyClass' => 'home', 'roomCode' => '', 'langUrl' => '/de', 'level' => '2', 'levelTxt' => 'Easy']);
});
Route::get('/normal', function () {
  return view('en/ai', ['headTitle' => 'Normal', 'bodyClass' => 'home', 'roomCode' => '', 'langUrl' => '/binh-thuong', 'level' => '3', 'levelTxt' => 'Normal']);
});
Route::get('/hard', function () {
  return view('en/ai', ['headTitle' => 'Hard', 'bodyClass' => 'home', 'roomCode' => '', 'langUrl' => '/kho', 'level' => '4', 'levelTxt' => 'Hard']);
});
Route::get('/hardest', function () {
  return view('en/ai', ['headTitle' => 'Hardest', 'bodyClass' => 'home', 'roomCode' => '', 'langUrl' => '/kho-nhat', 'level' => '5', 'levelTxt' => 'Hardest']);
});
Route::get('/play-with-ai', function () {
  return redirect('/en');
});
Route::get('/play-with-ai/easiest', function () {
  return redirect('/easiest');
});
Route::get('/play-with-ai/newbie', function () {
  return redirect('/newbie');
});
Route::get('/play-with-ai/easy', function () {
  return redirect('/easy');
});
Route::get('/play-with-ai/normal', function () {
  return redirect('/normal');
});
Route::get('/play-with-ai/hard', function () {
  return redirect('/hard');
});
Route::get('/play-with-ai/hardest', function () {
  return redirect('/hardest');
});

Route::get('/about-us', function () {
    return view('en/about', ['headTitle' => 'About Us', 'bodyClass' => 'about', 'roomCode' => '', 'langUrl' => '/gioi-thieu']);
});
Route::get('/gioi-thieu', function () {
    return view('about', ['headTitle' => 'Giới thiệu', 'bodyClass' => 'about', 'roomCode' => '', 'langUrl' => '/about-us']);
});
Route::get('/contact-us', function () {
    return view('en/contact', ['headTitle' => 'Contact Us', 'bodyClass' => 'contact', 'roomCode' => '', 'langUrl' => '/lien-he']);
});
Route::get('/lien-he', function () {
    return view('contact', ['headTitle' => 'Liên hệ', 'bodyClass' => 'contact', 'roomCode' => '', 'langUrl' => '/contact-us']);
});
Route::get('/rooms', [
    "uses" => 'RoomController@index_en',
    "as" => 'index_en'
]);
Route::get('/room/{code}', function($code) {
  return view('en/roomHost', ['headTitle' => 'Host - Room: '.$code, 'bodyClass' => 'room', 'roomCode' => $code, 'langUrl' => '/phong/'.$code]);
});
Route::get('/room/{code}/invited', function($code) {
  return view('en/roomGuest', ['headTitle' => 'Guest - Room: '.$code, 'bodyClass' => 'room', 'roomCode' => $code, 'langUrl' => '/phong/'.$code.'/duoc-moi']);
});
Route::get('/room/{code}/white', function($code) {
  return view('en/roomWhite', ['headTitle' => 'White - Room: '.$code, 'bodyClass' => 'room', 'roomCode' => $code, 'langUrl' => '/phong/'.$code.'/trang']);
});
Route::get('/room/{code}/black', function($code) {
  return view('en/roomBlack', ['headTitle' => 'Black - Room: '.$code, 'bodyClass' => 'room', 'roomCode' => $code, 'langUrl' => '/phong/'.$code.'/den']);
});
Route::get('/danh-sach-phong', [
    "uses" => 'RoomController@index',
    "as" => 'index'
]);
Route::get('/phong/{code}', function($code) {
  return view('roomHost', ['headTitle' => 'Chủ - Phòng: '.$code, 'bodyClass' => 'room', 'roomCode' => $code, 'langUrl' => '/room/'.$code]);
});
Route::get('/phong/{code}/duoc-moi', function($code) {
  return view('roomGuest', ['headTitle' => 'Khách - Phòng: '.$code, 'bodyClass' => 'room', 'roomCode' => $code, 'langUrl' => '/room/'.$code.'/invited']);
});
Route::get('/phong/{code}/trang', function($code) {
  return view('roomWhite', ['headTitle' => 'Trắng - Phòng: '.$code, 'bodyClass' => 'room', 'roomCode' => $code, 'langUrl' => '/room/'.$code.'/white']);
});
Route::get('/phong/{code}/den', function($code) {
  return view('roomBlack', ['headTitle' => 'Đen - Phòng: '.$code, 'bodyClass' => 'room', 'roomCode' => $code, 'langUrl' => '/room/'.$code.'/black']);
});
Route::post('/createRoom', [
  "uses" => 'RoomController@create',
  "as" => 'create'
]);
Route::get('/getPass/{code}', [
  "uses" => 'RoomController@getPass',
  "as" => 'getPass'
]);
Route::post('/changePass', [
  "uses" => 'RoomController@changePass',
  "as" => 'changePass'
]);
Route::post('/doiPass', [
  "uses" => 'RoomController@doiPass',
  "as" => 'doiPass'
]);
Route::post('/updateFEN', [
  "uses" => 'RoomController@store',
  "as" => 'store'
]);
Route::get('/readFEN/{code}', [
  "uses" => 'RoomController@show',
  "as" => 'show'
]);
Route::get('/getFEN/{code}', [
  "uses" => 'RoomController@getEventStream',
  "as" => 'getEventStream'
]);
Route::post('/processMail', [
  "uses" => 'MailController@send',
  "as" => 'send'
]);
Route::post('/xulyMail', [
  "uses" => 'MailController@gui',
  "as" => 'gui'
]);