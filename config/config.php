<?php
namespace Modules\Twitchstreams\Config;

class Config extends \Ilch\Config\Install
{
    public $config = array
    (
        'key' => 'twitchstreams',
        'icon_small' => 'twitchstreams.png',
        'system_modules' => true,
        'languages' => array
        (
            'de_DE' => array
            (
                'name' => 'Twitchstreams',
                'description' => 'Hier können Twitch-Streamer verwaltet werden.',
            ),
            'en_EN' => array
            (
                'name' => 'Twitchstreams',
                'description' => 'Here you can manage twitch streamer',
            ),
        )
    );
    
    public function install()
    {
        $this->db()->queryMulti($this->getInstallSql());
        
        $databaseConfig = new \Ilch\Config\Database($this->db());
        $databaseConfig->set('twitchstreams_requestEveryPageCall', '0');
    }
    
    public function uninstall()
    {
        $this->db()->queryMulti("DROP TABLE `[prefix]_twitchstreams_streamer`");
        $this->db()->queryMulti("DELETE FROM `[prefix]_config` WHERE `key` = `twitchstreams_requestEveryPageCall`");        
    }
    
    public function getInstallSql()
    {
        return 'CREATE TABLE IF NOT EXISTS `[prefix]_twitchstreams_streamer` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `user` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                `online` int(2) NOT NULL,
                `game` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                `viewers` int(11) NOT NULL,
                `previewMedium` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                `link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                `createdAt` date NOT NULL,
                PRIMARY KEY(`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;';
    }
    
}
