<?php

namespace Appoets\LaravelSetup\Helpers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;


class EnvironmentManager
{
    /**
     * @var string
     */
    private $envPath;

    /**
     * @var string
     */
    private $envExamplePath;

    private $env;
    private $backupPath;
    private $autoBackup = false;

    /**
     * Set the .env and .env.example paths.
     */
    public function __construct()
    {
        $this->envPath = base_path('.env');
        $this->envExamplePath = base_path('.env.example');

        $backupPath =  $this->envExamplePath;
        $env = $this->envPath;

        if(file_exists($env)){
            $this->env = $env;
        } else {
            return false;
        }

    }

    public function changeEnv($data = array())
    {
        if(count($data) > 0){

            $env = $this->getContent();

            foreach($data as $dataKey => $dataValue){
                foreach($env as $envKey => $envValue){
                    if($dataKey === $envKey){
                        $env[$envKey] = $dataValue;
                    }
                }
            }
            return $this->save($env);
        }
        throw new DotEnvException(trans('dotenv-editor::class.array_needed'), 0);
    }

    public function getContent()
    {
        return $this->envToArray($this->env);
    }


    protected function envToArray($file)
    {
        $string = file_get_contents($file);
        $string = preg_split('/\n+/', $string);
        $returnArray = array();

        foreach($string as $one){
            if (preg_match('/^(#\s)/', $one) === 1) {
                continue;
            }
            $entry = explode("=", $one, 2);
            $returnArray[$entry[0]] = isset($entry[1]) ? $entry[1] : null;
        }

        return array_filter($returnArray,function($key) { return !empty($key);},ARRAY_FILTER_USE_KEY);
    }


    protected function save($array)
    {
        if(is_array($array)){
            $newArray = array();
            $c = 0;
            foreach($array as $key => $value){
                $newArray[$c] = $key . "=" . $value;
                $c++;
            }

            $newArray = implode("\n", $newArray);

            file_put_contents($this->env, $newArray);

            return true;
        }
        return false;
    }


    /**
     * Get the content of the .env file.
     *
     * @return string
     */
    public function getEnvContent()
    {
        if (!file_exists($this->envPath)) {
            if (file_exists($this->envExamplePath)) {
                copy($this->envExamplePath, $this->envPath);
            } else {
                touch($this->envPath);
            }
        }

        return file_get_contents($this->envPath);
    }

    /**
     * Save the edited content to the file.
     *
     * @param Request $input
     * @return string
     */
    public function saveFile(Request $input)
    {
        $message = trans('messages.environment.success');

        try {
            // file_put_contents($this->envPath, $input->get('envConfig'));

            $tt = $this->changeEnv([
                'DB_HOST'   => $input->get('db_host'),
                'DB_DATABASE'   => $input->get('db_name'),
                'DB_USERNAME'   => $input->get('db_user'),
                'DB_PASSWORD'   => $input->get('db_password'),
            ]);

        }
        catch(Exception $e) {
            $message = trans('messages.environment.errors');
        }

        return $message;
    }
}