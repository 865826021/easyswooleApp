<?php

use EasySwoole\Component\Context\ContextManager;
use EasySwoole\Component\Context\Exception\ModifyError;
use EasySwoole\Component\Di;
use EasySwoole\EasySwoole\Logger;
use EasySwoole\Http\Message\Request;

if (!function_exists('dd')) {
    /**
     * @param $data
     *
     * @return void
     *
     * @author qap <qiuapeng921@163.com>
     * @date 2019/4/22 9:01
     */
    function dd($data)
    {
        echo '--------------------调试输出-------------------------' . PHP_EOL;
        print_r($data);
        echo '----------------------------------------------------' . PHP_EOL;
    }
}

if (!function_exists('array_map_recursive')) {
    /**
     * 输入数据过滤
     *
     * @param $filter
     * @param $data
     * @return array
     *
     * @author  邱阿朋 <apqiu@suntekcorps.com>
     * @date    2019/4/18 23:17
     */
    function array_map_recursive($filter, $data)
    {
        $result = array();
        foreach ($data as $key => $val) {
            $result[$key] = is_array($val)
                ? array_map_recursive($filter, $val)
                : call_user_func($filter, $val);
        }
        return $result;
    }
}

if (!function_exists('app')) {
    /**
     * 获取Di容器
     * @param null $abstract
     * @return Di|null
     * @throws Throwable
     */
    function app($abstract = null)
    {
        if (is_null($abstract)) {
            return Di::getInstance();
        }
        return Di::getInstance()->get($abstract);
    }
}


if (!function_exists('object_array')) {
    /**
     * 对象转数组
     * @param $array
     *
     * @return array
     *
     * @author qap <qiuapeng921@163.com>
     * @date 2019/4/18 17:48
     */
    function object_array($array)
    {
        if (is_object($array)) {
            $array = (array)$array;
        }
        if (is_array($array)) {
            foreach ($array as $key => $value) {
                $array[$key] = object_array($value);
            }
        }
        return $array;
    }
}


if (!function_exists('array_object')) {
    /**
     * 数组转对象
     * @param $array
     *
     * @return StdClass
     *
     * @author qap <qiuapeng921@163.com>
     * @date 2019/4/18 17:50
     */
    function array_object($array)
    {
        if (is_array($array)) {
            $obj = new StdClass();
            foreach ($array as $key => $val) {
                $obj->$key = $val;
            }
        } else {
            $obj = $array;
        }
        return $obj;
    }
}
if (!function_exists('set_context')) {
    /**
     * 设置上下文
     * @param $key
     * @param $value
     * @param int $cid
     *
     * @return void
     *
     * @throws ModifyError
     * @author qap <qiuapeng921@163.com>
     * @date 19-4-28 上午9:16
     */
    function set_context($key, $value, $cid = 1)
    {
        ContextManager::getInstance()->set($key, $value, $cid);
    }
}

if (!function_exists('get_context')) {
    /**
     *获取上下文
     *
     * @param $key
     * @param int $cid
     * @return null
     *
     * @author  邱阿朋 <apqiu@suntekcorps.com>
     * @date    2019/4/18 23:17
     */
    function get_context($key, $cid = 1)
    {
        return ContextManager::getInstance()->get($key, $cid);
    }
}


if (!function_exists('del_context')) {

    /*
     * 删除上下文
     *
     * @param int $cid
     * @return void
     *
     * @author  邱阿朋 <apqiu@suntekcorps.com>
     * @date    2019/4/18 23:17
     */
    /**
     * @param int $cid
     *
     * @return void
     *
     * @author qap <qiuapeng921@163.com>
     * @date 2019/4/22 8:50
     */
    function del_context($cid = 1)
    {
        ContextManager::getInstance()->destroy($cid);
    }
}

if (!function_exists('recordLog')) {
    /**
     * 日志记录
     * @param $content
     *
     * @return void
     *
     * @author qap <qiuapeng921@163.com>
     * @date 2019/4/22 8:50
     */
    function recordLog($content)
    {
        Logger::getInstance()->log($content);
    }
}

if (!function_exists('pay_log')) {
    function pay_log($message)
    {
        \App\Utility\Logger::getInstance()->log($message, 1, 'DEBUG');
    }
}

if (!function_exists('getUrlPath')) {
    /**
     * 获取请求地址
     * @return string
     *
     * @author qap <qiuapeng921@163.com>
     * @date 2019/4/24 9:47
     */
    function getUrlPath()
    {
        $result = (new Request())->getUri()->getPath();
        return $result;
    }
}

if (!function_exists('arrayToTree')) {
    /**
     * 将数据格式转换成树形结构数组
     * @param $array
     *
     * @return array
     *
     * @author qap <qiuapeng921@163.com>
     * @date 19-4-28 上午11:38
     */

    function arrayToTree($array)
    {
        //第一步 构造数据
        $items = array();
        foreach ($array as $value) {
            $items[$value['permission_id']] = $value;
        }
        $tree = array();
        foreach ($items as $key => $item) {
            if (isset($items[$item['parent_id']])) {
                $items[$item['parent_id']]['son'][] = &$items[$key];
            } else {
                $tree[] = &$items[$key];
            }
        }
        return $tree;
    }
}

if (!function_exists('arraySort')) {
    /**
     * 二维数组根据某个字段排序
     * @param array $array 要排序的数组
     * @param string $keys 要排序的键字段
     * @param int $sort 排序类型  SORT_ASC     SORT_DESC
     *
     * @return mixed
     *
     * @author qap <qiuapeng921@163.com>
     * @date 19-4-29 上午11:49
     */
    function arraySort($array, $keys, $sort = SORT_DESC)
    {
        $keysValue = [];
        foreach ($array as $k => $v) {
            $keysValue[$k] = $v[$keys];
        }
        array_multisort($keysValue, $sort, $array);
        return $array;
    }
}

if (!function_exists('xmlToArray')) {
    /**
     * xml转array
     * @param $xml
     *
     * @return mixed
     *
     * @author qap <qiuapeng921@163.com>
     * @date 2019/4/4 14:53
     */
    function xmlToArray($xml)
    {
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $values;
    }
}

if (!function_exists('arrayToXml')) {
    /**
     * array转xml
     * @param array $arr 数组
     * @return string   $xml     xml字符串
     */
    function arrayToXml($arr)
    {
        $xml = "<xml>";
        foreach ($arr as $key => $val) {
            if (is_numeric($val)) {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            } else {
                $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
            }
        }
        $xml .= "</xml>";
        return $xml;
    }
}