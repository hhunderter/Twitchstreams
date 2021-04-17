<?php

namespace Modules\Twitchstreams\Config;

class Config extends \Ilch\Config\Install
{
    public $config = [
        'key' => 'twitchstreams',
        'version' => '1.4.0',
        'icon_small' => 'fa-twitch',
        'author' => 'Fasse, Fabian',
        'languages' => [
            'de_DE' => [
                'name' => 'Twitchstreams',
                'description' => 'Hier können Twitch-Streamer verwaltet werden.',
            ],
            'en_EN' => [
                'name' => 'Twitchstreams',
                'description' => 'Here you can manage Twitch streamer',
            ],
        ],
        'boxes' => [
            'streamer' => [
                'de_DE' => [
                    'name' => 'Twitchstreams'
                ],
                'en_EN' => [
                    'name' => 'Twitchstreams'
                ],
            ],
        ],
        'ilchCore' => '2.1.41',
        'phpVersion' => '7.0',
    ];

    public function install()
    {
        $this->db()->queryMulti($this->getInstallSql());
        
        $databaseConfig = new \Ilch\Config\Database($this->db());
        $databaseConfig->set('twitchstreams_requestEveryPageCall', '0')
            ->set('twitchstreams_apikey', '')
            ->set('twitchstreams_domains', '');
    }

    public function uninstall()
    {
        $this->db()->queryMulti('DROP TABLE `[prefix]_twitchstreams_streamer`');
        $this->db()->queryMulti("DELETE FROM `[prefix]_config` WHERE `key` = 'twitchstreams_requestEveryPageCall';
            DELETE FROM `[prefix]_config` WHERE `key` = 'twitchstreams_apikey';
            DELETE FROM `[prefix]_config` WHERE `key` = 'twitchstreams_domains';");
    }

    public function getInstallSql()
    {
        return 'CREATE TABLE IF NOT EXISTS `[prefix]_twitchstreams_streamer` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `user` VARCHAR(255) NOT NULL,
            `title` VARCHAR(255) NOT NULL,
            `online` INT(1) NOT NULL,
            `game` VARCHAR(255) NOT NULL,
            `viewers` INT(11) NOT NULL,
            `previewMedium` VARCHAR(255) NOT NULL,
            `createdAt` DATETIME NOT NULL,
            PRIMARY KEY(`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1;';
    }

    public function getUpdate($installedVersion)
    {
        switch ($installedVersion) {
            case "1.0":
                // Convert tables to new character set and collate
                $this->db()->query('ALTER TABLE `[prefix]_twitchstreams_streamer` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;');
            case "1.1":
                // Delete non use link
                $this->db()->query('ALTER TABLE `[prefix]_twitchstreams_streamer` DROP COLUMN `link`;');
            case "1.2.0":
                // update zu 1.3.0
                /*
                Change Font Awesome icons
                PSR2 Fix
                Some Beauty code fixes
                Fix twitch api
                */
            case "1.3.0":
                // update zu 1.3.1
                /*
                add Parent Domain
                */
                $databaseConfig = new \Ilch\Config\Database($this->db());
                $databaseConfig->set('twitchstreams_domains', '');
            case "1.3.1":
                // update zu 1.3.2
                /*
                some fixes
                */
            case "1.3.2":
                // update zu 1.3.3
                /*
                Update Settings info
                */
            case "1.3.3":
                // update zu 1.4.0
                /*
                ADD Option Show offline Streams
                */
                $databaseConfig = new \Ilch\Config\Database($this->db());
                $databaseConfig->set('twitchstreams_showOffline', false);
        }
    }
}
