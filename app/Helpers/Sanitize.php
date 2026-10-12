<?php

class Sanitize {
    public static function clean($data) {
        $data = trim($data);
        $data = strip_tags($data); // Menghapus tag HTML liar, tapi tidak mengubah karakter &
        return $data;
    }
}