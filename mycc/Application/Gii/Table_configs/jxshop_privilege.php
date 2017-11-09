<?php
return array(
	'tableName' => 'jxshop_privilege',    // 表名
	'tableCnName' => '权限表',  // 表的中文名
	'moduleName' => 'Admin',  // 代码生成到的模块
	'withPrivilege' => FALSE,  // 是否生成相应权限的数据
	'topPriName' => '',        // 顶级权限的名称
	'digui' => 1,             // 是否无限级（递归）
	'diguiName' => 'pri_name',        // 递归时用来显示的字段的名字，如cat_name（分类名称）
	'pk' => 'id',    // 表中主键字段名称
	/********************* 要生成的模型文件中的代码 ******************************/
	// 添加时允许接收的表单中的字段
	'insertFields' => "array('pri_name','modile_name','controller_name','action_name','parent_id')",
	// 修改时允许接收的表单中的字段
	'updateFields' => "array('id','pri_name','modile_name','controller_name','action_name','parent_id')",
	'validate' => "
		array('pri_name', 'require', '权限名称不能为空！', 1, 'regex', 3),
		array('pri_name', 'number', '权限名称必须是一个整数！', 1, 'regex', 3),
		array('modile_name', 'require', '模块名不能为空！', 1, 'regex', 3),
		array('modile_name', '1,60', '模块名的值最长不能超过 60 个字符！', 1, 'length', 3),
		array('controller_name', 'require', '控制器名不能为空！', 1, 'regex', 3),
		array('controller_name', '1,60', '控制器名的值最长不能超过 60 个字符！', 1, 'length', 3),
		array('action_name', 'require', '方法名不能为空！', 1, 'regex', 3),
		array('action_name', '1,60', '方法名的值最长不能超过 60 个字符！', 1, 'length', 3),
		array('parent_id', 'require', '上一级权限不能为空！', 1, 'regex', 3),
		array('parent_id', 'number', '上一级权限必须是一个整数！', 1, 'regex', 3),
	",
	/********************** 表中每个字段信息的配置 ****************************/
	'fields' => array(
		'pri_name' => array(
			'text' => '权限名称',
			'type' => 'text',
			'default' => '',
		),
		'modile_name' => array(
			'text' => '模块名',
			'type' => 'text',
			'default' => '',
		),
		'controller_name' => array(
			'text' => '控制器名',
			'type' => 'text',
			'default' => '',
		),
		'action_name' => array(
			'text' => '方法名',
			'type' => 'text',
			'default' => '',
		),
		'parent_id' => array(
			'text' => '上一级权限',
			'type' => 'text',
			'default' => '',
		),
	),
	/**************** 搜索字段的配置 **********************/
	'search' => array(
	),
);