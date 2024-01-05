<?php

use App\Models\Notification;
use App\Models\Order;
use App\Models\User;
use App\Notifications\Invoice;
use Carbon\Carbon;

function rupiah($amount){
    return 'Rp '.number_format($amount, 0, ',', '.');
}
function tanggal($tanggal){
    return date('d M Y', strtotime($tanggal));
}
function tgltime($tanggal){
    return date('d M Y H:i', strtotime($tanggal));
}
function waktu($tanggal){
    Carbon::setLocale('id');
    return Carbon::createFromTimestamp(strtotime($tanggal))->diffForHumans();
}
function angka($amount){
    return number_format($amount, 0, ',', '.');
}
function pagi($currentPage, $lastPage, $params = []){
    return view('layout.partials._paginate', compact('currentPage', 'lastPage', 'params'));
}
function rating($countReview, $sumRating){ 
    $rating = ($countReview != 0) ?$sumRating / $countReview : 3;
    return view('layout.partials._rating', compact('rating', 'countReview'));
}
function ratingValue($countReview, $sumRating){ 
    $rating = ($countReview != 0) ? $sumRating / $countReview : 3;
    return number_format((float)$rating, 1, '.', '');
}
function star($rating){
    return view('layout.partials._star', compact('rating'));
}
function isRole($role){
    if(!auth()->user()){
        return false;
    }elseif(auth()->user()->role == $role){
        return true;
    }
    return false;
}
function discount($value, $type, $subtotal = false){//subtotal after variant discount
    if(!$subtotal){
        if($type == 'Percent'){
            return "$value%";
        }
        return ($value/1000).'K';
    }else{
        if($type == 'Percent'){
            return ($subtotal * $value) / 100;
        }
        return $value;
    }
}
function statusColor($status){
    if($status == 'Pending'){
        return 'warning';
    }elseif($status == 'Process'){
        return 'dark';
    }elseif($status == 'Ready'){
        return 'primary';
    }elseif($status == 'Done'){
        return 'success';
    }
    return 'danger';
}

function formatPhone($phone){
    // kadang ada penulisan no hp 0811 239 345
    $phone = str_replace(" ","",$phone);
    // kadang ada penulisan no hp (0274) 778787
    $phone = str_replace("(","",$phone);
    // kadang ada penulisan no hp (0274) 778787
    $phone = str_replace(")","",$phone);
    // kadang ada penulisan no hp 0811.239.345
    $phone = str_replace(".","",$phone);

    $hp = $phone;

    // cek apakah no hp mengandung karakter + dan 0-9
    if(!preg_match('/[^+0-9]/',trim($phone))){
        // cek apakah no hp karakter 1-3 adalah +62
        if(substr(trim($phone), 0, 3)=='+62'){
            // $hp = trim($phone);
            $hp = substr(trim($phone), 3);
        }
        // cek apakah no hp karakter 1-2 adalah 62
        elseif(substr(trim($phone), 0, 2)=='62'){
            // $hp = '+62'.substr(trim($phone), 1);
            $hp = substr(trim($phone), 2);
        }
        // cek apakah no hp karakter 1 adalah 0
        elseif(substr(trim($phone), 0, 1)=='0'){
            // $hp = '+62'.substr(trim($phone), 1);
            $hp = substr(trim($phone), 1);
        }
    }
    return $hp;
}

function terbilang($angka)
{
    $angka = abs($angka);
    $baca = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");

    $terbilang = "";
    if ($angka < 12) {
        $terbilang = " " . $baca[$angka];
    } else if ($angka < 20) {
        $terbilang = terbilang($angka - 10) . " belas";
    } else if ($angka < 100) {
        $terbilang = terbilang($angka / 10) . " puluh" . terbilang($angka % 10);
    } else if ($angka < 200) {
        $terbilang = " seratus" . terbilang($angka - 100);
    } else if ($angka < 1000) {
        $terbilang = terbilang($angka / 100) . " ratus" . terbilang($angka % 100);
    } else if ($angka < 2000) {
        $terbilang = " seribu" . terbilang($angka - 1000);
    } else if ($angka < 1000000) {
        $terbilang = terbilang($angka / 1000) . " ribu" . terbilang($angka % 1000);
    } else if ($angka < 1000000000) {
        $terbilang = terbilang($angka / 1000000) . " juta" . terbilang($angka % 1000000);
    }
    return $terbilang;
}
if (!function_exists('filter_number')) {
    function filter_number($param)
    {
        return filter_var($param, FILTER_SANITIZE_NUMBER_INT);
    }
}
function data_order(){
    $data = Order::where('status','=','Pending')->get();
    return count($data);
}