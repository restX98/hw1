<?php
class AssetMgr {
    private static $clientPath = '/hw1/client';
    private static $css = [];
    private static $js = [];

    public static function addCss($path) {
        $path = self::$clientPath . $path;
        self::$css[] = $path;
    }

    public static function addJs($path) {
        $path = self::$clientPath . $path;
        self::$js[] = $path;
    }

    public static function renderCss() {
        foreach (self::$css as $path) {
            echo '<link rel="stylesheet" href="' . $path . '">';
        }
    }

    public static function renderJs() {
        foreach (self::$js as $path) {
            echo '<script src="' . $path . '" defer></script>';
        }
    }
}
?>