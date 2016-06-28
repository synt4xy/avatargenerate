<?php
/*
 * Project: AvatarImage Generator
 * Created by: Synt4x (Skype name: musecms)
 * Project Started: 26/06/2016
 * Project Ended: 27/06/2016
 */

class AvatarImage
{

    /*
     * Get the version to compare against
     * the latest version of AvatarImage.
     *
     * @type    string
     */

    protected $version = "1.0.2";


    /*
     * Set the output directory that the
     * script will write all javascript
     * files to.
     *
     * @type    string
     */

    protected $output = __DIR__ . '/json';


    /*
     * Construct the class and call the
     * 'convertToJSON' method.
     *
*/

    public function __construct()
    {
        $this->convertToJSON( 'http://habboo-a.akamaihd.net/gordon/PRODUCTION-201606242205-761645438/figuremap.xml' );
    }


    /*
     * Load an XML file and then assemble it
     * in a json-friendly format which will
     * be utilised by the jQuery plugin.
     *
     */

    public function convertToJSON( $xmlFile )
    {
        $xmlFileContents = file_get_contents( $xmlFile );
        $xmlFileContents = simplexml_load_string( $xmlFileContents );


        /*
         * This foreach loop creates an array
         * that can then be converted to json
         * and used within the jQuery plugin.
         *
         * This creates the output file: palettes.json
         */

        $palettes = array();

        foreach( $xmlFileContents->xpath( 'colors/palette' ) as $palette )
        {
            $id = (int) $palette->attributes()->id;

            $palettes[ $id ] = array();

            foreach( $palette->xpath( 'color' ) as $color )
            {
                $colorID = (int) $color->attributes()->id;

                $palettes[ $id ][ $colorID ] = array(
                    'index'         => (int) $color->attributes()->index,
                    'club'          => (int) $color->attributes()->club,
                    'selectable'    => (int) $color->attributes()->selectable,
                    'hex'           => (string) $color,
                );
            }
        }

        $toJSON = json_encode( $palettes );

        if( $this->writeJson( "{$this->output}/palettes.json", $toJSON ) )
            echo "Successfully wrote palettes.json </br>";
        else
            echo "Could not write to file palettes.json </br>";


        /*
         * This foreach loop creates an array
         * that can then be converted to json
         * and used within the jQuery plugin.
         *
         * This creates the output file: settypes.json
         */

        $settypes = array();

        foreach( $xmlFileContents->xpath( 'sets/settype' ) as $key => $settype )
        {
            $settypes[ $key ] =  array(
                'paletteid' => (int)    $settype->attributes()->paletteid,
                'type'      => (string) $settype->attributes()->type,
                'sets'      => array(),
            );

            foreach( $settype->xpath( 'set' ) as $set )
            {
                $id = (int) $set->attributes()->id;

                $settypes[ $key ]['sets'][ $id ] = array(
                    'gender'        => (string) $set->attributes()->gender,
                    'club'          => (int) $set->attributes()->club,
                    'colorable'     => (int) $set->attributes()->colorable,
                    'selectable'    => (int) $set->attributes()->selectable,
                    'preselectable' => (int) $set->attributes()->preselectable,
                );
            }
        }

        $toJSON = json_encode( $settypes );

        if( $this->writeJson( "{$this->output}/settypes.json", $toJSON ) )
            echo "Successfully wrote settypes.json </br>";
        else
            echo "Could not write to file settypes.json </br>";

    }


    /*
     * This method takes an output file and
     * write to it. It will create the directory
     * based on the $output variable if it does
     * not exist.
     *
     * @param   $outputFile string
     * @param   $json       string
     *
     * @return  boolean
     */

    private function writeJson( $outputFile, $json )
    {
        if( is_writable( $this->output ) )
        {
            if( ! is_dir( $this->output ) )
            {
                mkdir( $this->output );
            }

            $f = fopen( $outputFile, "w" );

            fwrite( $f, $json );
            fclose( $f );

            return true;
        }

        return false;
    }

}