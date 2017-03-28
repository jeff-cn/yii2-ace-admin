<?php
/**
 * Created by PhpStorm.
 * User: liujinxing
 * Date: 2017/3/28
 * Time: 13:39
 */

namespace Admin\Strategy;

class JqGrid extends  Strategy
{
    private $request = [];

    public function getRequest()
    {
        // 接收参数参数
        $intPage = (int)I('post.page'); // 第几页
        $intRows = (int)I('post.rows'); // 每页多少条
        $field = I('post.sidx');      // 排序字段
        $sort = I('post.sord'); // 排序方式
        $params = I('post.params'); // 查询参数

        // 处理查询数据条数
        $intPage = $intPage ? $intPage : 1;  // 默认第一页
        $intStart = ($intPage - 1) * $intRows;

        // 处理排序信息
        $sort = $sort == 'asc' ? 'ASC' : 'DESC';

        // 返回查询字段信息
        $this->request = [
            'sort' => $sort,    // 排序方式
            'field' => $field, // 排序字段
            'offset' => $intStart, // 查询开始位置
            'limit' => $intRows, // 查询数据条数
            'page' => $intPage, // 第几页
            'params' => $params, // 查询参数
        ];

        return $this->request;
    }

    public function handleResponse($data, $total, $params = null)
    {
        $intTotalPage = $total > 0 ? ceil($total / $this->request['limit']) : 0;

        // 返回数据
        return [
            'page' => $this->request['page'], // 第几页
            'total' => $intTotalPage, // 总页数
            'records' => $total, // 总数据条数
            'rows' => $data, // 数据
        ];
    }
}