<?php


class acfDeleteCharactersCLass {

    private $_debug = false;

    private $_srcData;

    private function setPlugin( $param )
    {
        if (function_exists('acf_add_options_page')) {

            acf_add_options_page(array(
                'menu_title' => 'Удалить символы',
                'menu_slug'  => 'acf-delete-characters',
                'capability' => 'edit_posts',
                'redirect'   => false,
                'icon_url'   => 'dashicons-tag'
            ));

            $this->_debug = $param['debug'];
        }
        else
            throw new Exception('Для работы необходим плагин ACF');
    }

    public function __construct( $param )
    {
        try {

            $this->setPlugin( $param );
            $this->start();

        }
        catch (Exception $e)
        {
            if ( $this->_debug )
                add_action( 'wp_footer', function() use ( $e ) {
                    echo "<script>";
                    echo "console.group('ACF-SEO-Metatags: {$e->getMessage()}');";
                    echo "console.warn(\"Файл: '{$e->getFile()}\");";
                    echo "console.warn(\"Строке: '{$e->getLine()}\");";
                    echo "console.groupEnd();";
                    echo "</script>";
                });
        }
    }

    private function setSrcData()
    {
        $this->_srcData = get_field('delete-characters', 'options');

    }

    private function selectMethod()
    {
        if ( class_exists( 'All_in_One_SEO_Pack_Module' ) )
            $this->handleWithSeoPlugin();
        else
            $this->handleWithoutSeoPlugin();
    }

    private function handleWithoutSeoPlugin()
    {
//        add_filter( 'pre_get_document_title', function( $a ){
//            return 'title без лишних символов'.$a;
//        },20, 1);

    }

    private function handleWithSeoPlugin()
    {
        $data = $this->_srcData;

        if ( $this->_srcData[0]['title'] * 1 === 1 )
            add_filter('aioseop_title', function( $a ) use ( $data ){
                return str_replace( explode( " ", $data[0]['char_title'] ), '', $a );
            },12);

        if ( $this->_srcData[0]['description'] * 1 === 1 )
            add_filter('aioseop_description', function( $a ) use ( $data ){
                return str_replace( explode( " ", $data[0]['char_description'] ), '', $a );
            },12);

    }


    private function start()
    {

        $this->setSrcData();

        $this->selectMethod();

    }

}


?>