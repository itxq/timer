<?php
/**
 *  ==================================================================
 *        文 件 名: Timer.php
 *        概    要: 定时任务启动类
 *        作    者: IT小强
 *        创建时间: 2019-04-12 16:25:05
 *        修改时间:
 *        copyright (c) 2016 - 2019 mail@xqitw.cn
 *  ==================================================================
 */

namespace itxq\timer;

use taskphp\App;
use taskphp\Config;
use taskphp\Console;

/**
 * Class Timer 定时任务启动类
 * @package itxq\timer
 * @author IT小强
 * @createTime 2019-04-13 10:26:42
 */
class Timer
{
    /**
     * @var array 配置信息
     */
    protected $config = [];
    
    /**
     * @var string 分隔符
     */
    protected $ds = DIRECTORY_SEPARATOR;
    
    /**
     * @var string vendor目录
     */
    protected $vendorPath = '';
    
    /**
     * Timer 构造函数.
     * @param array $config
     * @param string $vendorPath
     */
    public function __construct(array $config = [], string $vendorPath = '')
    {
        if (empty($vendorPath)) {
            $vendorPath = dirname(__DIR__, 4);
        }
        if (!is_dir($vendorPath)) {
            Console::display('未指定vendor目录', true);
        }
        $this->vendorPath = realpath($vendorPath) . $this->ds;
        require $this->vendorPath . 'taskphp' . $this->ds . 'taskphp' . $this->ds . 'src' . $this->ds . 'taskphp' . $this->ds . 'base.php';
        
        $this->config = array_merge($this->config, $config);
    }
    
    /**
     * 启动
     * @author IT小强
     * @createTime 2019-04-13 09:56:12
     */
    public function run(): void
    {
        //加载配置信息
        Config::load($this->config);
        if (!defined('START_PATH')) {
            //定义启动文件入口标记
            define('START_PATH', dirname($this->vendorPath));
        }
        //运行框架
        App::run();
    }
    
    /**
     * 是否运行在命令行下
     * @return bool
     */
    protected function runningInConsole(): bool
    {
        return PHP_SAPI === 'cli' || PHP_SAPI === 'phpdbg';
    }
}
