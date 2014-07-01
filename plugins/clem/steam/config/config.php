<?php


return array(
    'api' => array(
        'expire' => array(
            'user' => array(
                'days'    => 7,
                'hours'   => 0,
                'minutes' => 0
                ),
            'game' => array(
                'hours'   => 0,
                'minutes' => 10
                )
            ),
        // only use regexpressions for user input data.???
        'patterns' => array(
            'steam_id_input' => '^(STEAM_[0-5]:[0-1]:\d+)|(\d+)$',
            'steam_id64'     => '^[0-9]+$',
            'key'            => '^([a-zA-Z0-9]){32}$',
            'count'          => '^[0-9]+$'
            ),
        'conversion' => array(
            '1' => hexdec('0x0110000100000000'),
            '7' => hexdec('0x0170000000000000') //unsupported but documented on steam api
            ),
        'urltemplates' => array(
            'data'  => 'http://api.steampowered.com/{{interface}}/{{method}}/v{{version}}/',
            'app_image' => 'http://media.steampowered.com/steamcommunity/public/images/apps/{{appid}}/{{logoid}}.jpg',
            'app_page'  => 'http://store.steampowered.com/app/{{appid}}/',
            ),

        'methods' => array(
            'getplayersummaries' => array(
                'urltemplate' => 'data',
                'parameters' => array(
                    'required' => array(
                        'key'      => null,
                        'steamids' => null
                        ),
                    'static'   => array(
                        'interface' => 'ISteamUser',
                        'method'    => 'GetPlayerSummaries',
                        'version'   => '0002',
                        'format'    => 'json'
                        )
                    )
                ),
            'getrecentlyplayedgames' => array(
                'urltemplate' => 'data',
                'parameters' => array(
                    'required' => array(
                        'key'     => null,
                        'steamid' => null
                        ),
                    'static'   => array(
                        'count'     => '30',
                        'interface' => 'IPlayerService',
                        'method'    => 'GetRecentlyPlayedGames',
                        'version'   => '0001',
                        'format'    => 'json'
                        )
                    )
                )
            ),// /methods

        'models' => array(
            'user' => array(
                'dbdatakeys' => array(
                        'steam_id_input'     => null,
                        'steam_id_sixtyfour' => 'steamid',
                        'persona_name'       => 'personaname',
                        'persona_state'      => 'personastate',
                        'profile_url'        => 'profileurl',
                        'profile_image_url'  => 'avatarmedium'
                    )
                ),
            'game' => array(
                'dbdatakeys' => array(
                        'user_id'          => null,
                        'name'             => 'name',
                        'app_id'           => 'appid',
                        'app_url'          => null,
                        'app_image_url'    => null,
                        'rank'             => null,
                        'playtime_recent'  => 'playtime_2weeks',
                        'playtime_forever' => 'playtime_forever',
                        'active'           => null
                    )
                )
            )// /models
        )
    );