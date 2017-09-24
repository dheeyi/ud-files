<?php


namespace UDFiles\App;


class Container
{
    private $defaultSettings = [
        'nameApp' => '',
        'database' => false,
        'displayErrors' => false,
    ];

    /**
     * Create new container
     *
     * @param array $values The parameters or objects.
     */
    public function __construct(array $values = [])
    {
        $userSettings = isset($values['settings']) ? $values['settings'] : [];
        $this->registerDefaultServices($userSettings);
    }

    /**
     * @param $userSettings
     */
    private function registerDefaultServices($userSettings)
    {
        $settings = array_merge($this->defaultSettings, $userSettings);

        foreach ($settings as $key => $value) {
            $this->register($key, $value);
        }
    }

    /**
     * @param $key
     * @param $value
     */
    private function register($key, $value)
    {
        $this->defaultSettings[$key] = $value;
    }

    /**
     * Get settings
     * @param string $key
     * @return array|mixed
     */
    public function getSetting($key = '')
    {
        return ($key == '') ? $this->defaultSettings : $this->defaultSettings[$key];
    }
}