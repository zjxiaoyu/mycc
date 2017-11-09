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


<div class="form-div">
    <form action="<?php echo U('lst')?>" name="searchForm">
        <select name="cat_id" id="">
            <option value="">请选择分类</option>
            <?php foreach($cat as $k=>$v) { if(I('get.cat_id')==$v['id']) $select="selected='selected'"; else $select=''; ?>
            <option <?php echo $select ?>  value="<?php echo $v['id']; ?>" ><?php echo str_repeat('-----/',$v['level']).$v['cate_name']; ?></option>
            <?php } ?>
        </select>
        商品名称:<input type="text" name="gn" value="<?php echo I('get.gn')?>" />
        本店价格:从<input type="text"  name="fp" value= "<?php echo I('get.fp')?>" />到<input type="text"  name="tp" value= "<?php echo I('get.tp')?>" />
        是否上架:<input type="radio" name="ios" value="0"  <?php if(I('get.ios')=="0" || empty(I('get.ios'))) echo "checked='checked'"?> />全部
                <input type="radio" name="ios" value="是"  <?php if(I('get.ios')=="是") echo "checked='checked'"?> />是
                <input type="radio" name="ios" value="否"  <?php if(I('get.ios')=="否") echo "checked='checked'"?> />否
        <input type="submit" value=" 搜索 " class="button" />
    </form>
</div>

<!-- 商品列表 -->
<form method="post" action="" name="listForm" onsubmit="">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr>
                <th>id</th>
                <th>logo</th>
                <th>商品名称</th>
                <th>市场价格</th>
                <th>本店价格</th>

                <th>是否上架</th>
                <th>操作</th>
            </tr>
                <?php foreach($data as $k=>$v ) { ?>
            <tr>
                <td align="center"> <?php echo $v['id'] ?></td>
                <td align="center"> <image src="<?php echo IMAGE_PATH.$v['sm_logo'] ?>"> </td>
                <td align="center"> <?php echo $v['goods_name'] ?></td>
                <td align="center"> <?php echo $v['market_price'] ?></td>
                <td align="center"> <?php echo $v['shop_price'] ?></td>

                <td ><?php echo $v['is_on_sale'] ?></td>
                <td >
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