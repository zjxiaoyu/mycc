<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>ECSHOP 管理中心 -<?php echo $_page_tile?> </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="/Public/Admin/Styles/general.css" rel="stylesheet" type="text/css" />
    <link href="/Public/Admin/Styles/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo $_page_btn_link?>"><?php echo $_page_btn_name?></a></span>
    <span class="action-span1"><a href="__GROUP__">ECSHOP 管理中心 -</a></span>
    <span id="search_id" class="action-span1"><?php echo $_page_tile?></span>
    <div style="clear:both"></div>
</h1>




<!-- 商品列表 -->
<form method="post" action="" name="listForm" onsubmit="">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr>
                <th>分类名称</th>
                <th>操作</th>
            </tr>
                <?php foreach($data as $k=>$v) { ?>
            <tr>
                <td ><?php echo str_repeat('-----/',$v['level']).$v['cate_name']; ?></td>
                <td align="center" >
                    <a href="<?php echo U('edit?id='.$v['id'])?>">编辑</a>
                    <a onclick="return confirm('确认删除吗?');" href="<?php echo U('delete?id='.$v['id'])?>">删除</a>
                </td>
            </tr>
             <?php  } ?>
        </table>
          <tr>
              <td  nowrap="true" colspan="7">
                  <!-- 分页开始 -->
                  <div id="page-table" cellspacing="0" align="right">
                      <?php echo $show?>
                  </div>
                  <!-- 分页结束 -->
              </td>

          </tr>

    </div>

</form>



<div id="footer">
    共执行 7 个查询，用时 0.028849 秒，Gzip 已禁用，内存占用 3.219 MB<br />
    版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>