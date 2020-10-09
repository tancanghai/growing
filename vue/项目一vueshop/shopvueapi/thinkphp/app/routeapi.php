<?php
return [
    // 定义资源路由
    '__rest__'=>[
        // 指向index模块的blog控制器
        'firstapi'=>'api/first',
        'indexapi'=>'api/index',
    ],
    // 定义普通路由
    //'hello/:id'=>'index/hello',
    'firstapi/blog'=>'api/first/blog',
];
