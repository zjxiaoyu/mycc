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


<!-- 搜索 -->
<div class="form-div search_form_div">
    <form action="/index.php/Admin/Attribute/lst" method="GET" name="search_form">
		<p>
			属性名：
	   		<input type="text" name="attr_name" size="30" value="<?php echo I('get.attr_name'); ?>" />
		</p>
		<p>
			属性类型：
			<input type="radio" value="-1" name="attr_type" <?php if(I('get.attr_type', -1) == -1) echo 'checked="checked"'; ?> /> 全部 
			<input type="radio" value="可选" name="attr_type" <?php if(I('get.attr_type', -1) == '可选') echo 'checked="checked"'; ?> />  
			<input type="radio" value="唯一" name="attr_type" <?php if(I('get.attr_type', -1) == '唯一') echo 'checked="checked"'; ?> />  
		</p>
		<p>
			类型名：
			<select name="type_id" id="">
				<?php
 $id=I('get.type_id'); foreach($typedata as $k=>$v) : if($id==$v['id']) $select="selected='selected'"; else $select =''; ?>
				<option  value="<?php echo $v['id']; ?>" <?php echo $select ?> > <?php echo $v['type_name']; ?> </option>
				<?php endforeach; ?>
			</select>

		</p>
		<p><input type="submit" value=" 搜索 " class="button" /></p>
    </form>
</div>
<!-- 列表 -->
<div class="list-div" id="listDiv">
	<table cellpadding="3" cellspacing="1">
    	<tr>
            <th >属性名</th>
            <th >属性类型</th>
            <th >可选的值</th>
            <th >类型名</th>
			<th width="60">操作</th>
        </tr>
		<?php foreach ($data as $k => $v): ?>            
			<tr class="tron">
				<td><?php echo $v['attr_name']; ?></td>
				<td><?php echo $v['attr_type']; ?></td>
				<td><?php echo $v['attr_type_value']; ?></td>
				<td><?php echo $v['type_name']; ?></td>
		        <td align="center">
		        	<a href="<?php echo U('edit?id='.$v['id'].'&p='.I('get.p')); ?>" title="编辑">编辑</a> |
	                <a href="<?php echo U('delete?id='.$v['id'].'&p='.I('get.p')); ?>" onclick="return confirm('确定要删除吗？');" title="移除">移除</a> 
		        </td>
	        </tr>
        <?php endforeach; ?> 
		<?php if(preg_match('/\d/', $page)): ?>  
        <tr><td align="right" nowrap="true" colspan="99" height="30"><?php echo $page; ?></td></tr> 
        <?php endif; ?> 
	</table>
</div>
<script>
</script>
<script type="text/javascript" charset="utf-8" src="/Public/Admin/Js/tron.js"></script>

<div id="footer">
    共执行 7 个查询，用时 0.028849 秒，Gzip 已禁用，内存占用 3.219 MB<br />
    版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>