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


    <link href="/Public/umeditor1_2_2-utf8-php/themes/default/css/umeditor.css" type="text/css" rel="stylesheet">
    <script type="text/javascript" src="/Public/umeditor1_2_2-utf8-php/third-party/jquery.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="/Public/umeditor1_2_2-utf8-php/umeditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/Public/umeditor1_2_2-utf8-php/umeditor.min.js"></script>
    <script type="text/javascript" src="/Public/umeditor1_2_2-utf8-php/lang/zh-cn/zh-cn.js"></script>


<div class="tab-div">
    <div id="tabbar-div">
        <p>
            <span class="tab-front" >通用信息</span>
            <span class="tab-back" >详细描述</span>
            <span class="tab-back" >会员价格</span>
            <span class="tab-back" >商品属性</span>
            <span class="tab-back" >商品相册</span>
        </p>
    </div>
    <div id="tabbody-div">
        <form enctype="multipart/form-data" action="<?php echo U('add') ?>" method="post">
            <table width="90%" id="general-table" align="center" class="_tab_content" >
                <tr>
                    <td class="label">主分类：</td>
                    <td>
                        <select name="cat_id" id="">
                            <option value="">请选择分类</option>
                            <?php foreach($data as $k=>$v) { ?>
                            <option value="<?php echo $v['id']; ?>" ><?php echo str_repeat('-----/',$v['level']).$v['cate_name']; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="label">拓展分类：</td>
                    <td>
                        <input onclick="addnewext(this)" type="button" value="添加一个拓展分类：">
                        <select name="ext_cat_id[]" >
                            <option value="">请选择分类</option>
                            <?php foreach($data as $k=>$v) { ?>
                            <option value="<?php echo $v['id']; ?>" ><?php echo str_repeat('-----/',$v['level']).$v['cate_name']; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="label">商品名称：</td>
                    <td><input type="text" name="goods_name" value=""size="30" />
                    <span class="require-field">*</span></td>
                </tr>
                <tr>
                    <td class="label">市场售价：</td>
                    <td>
                        <input type="text" name="market_price"  size="20"/>
                        <span class="require-field">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">本店售价：</td>
                    <td>
                        <input type="text" name="shop_price"  size="20"/>
                        <span class="require-field">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">是否上架：</td>
                    <td>
                        <input type="radio" name="is_on_sale" value="是"/> 是
                        <input type="radio" name="is_on_sale" value="否"/> 否
                    </td>
                </tr>
                <tr>
                    <td class="label">商品图片：</td>
                    <td>
                        <input type="file" name="logo" size="35" />
                    </td>
                </tr>

            </table>

           <!--详细描述-->
            <table width="90%" style="display:none" align="center"  class="_tab_content" >
                <tr>
                    <td class="label">商品简单描述：</td>
                    <td>
                        <textarea id="goods_desc" name="goods_desc" cols="40" rows="3"></textarea>
                    </td>
                </tr>
            </table>
            <!--会员价格-->
            <table width="90%" style="display:none" align="center"  class="_tab_content" >
                <tr>
                    <td class="label">主分类：</td>
                </tr>
            </table>
            <!--商品属性-->
            <table width="90%" style="display:none" align="center"  class="_tab_content" >
                <tr>
                    <td class="label">类型名：</td>
                    <td>
                        <select name="type_id" id="" >
                            <option value=" "  > 请选择类型 </option>
                            <?php
 foreach($typedata as $k=>$v) : ?>
                            <option value="<?php echo $v['id']; ?>"  > <?php echo $v['type_name']; ?> </option>
                            <?php endforeach; ?>
                        </select>
                        <ul id="attr_list"></ul>
                    </td>
                </tr>
            </table>
            <!--商品相册-->
            <table width="90%" style="display:none" align="center" class="_tab_content" >
                <tr>
                    <td class="label">主分类：</td>
                </tr>
            </table>

            <div class="button-div">
                <input type="submit" value=" 确定 " class="button"/>
                <input type="reset" value=" 重置 " class="button" />
            </div>
        </form>
    </div>
</div>

<script>
    UM.getEditor('goods_desc',{
        initialFrameWidth:500,
        initialFrameHeight:400
    });
    function addnewext(btn)
    {

       var newSel = $(btn).next('select').clone();
        $(btn).parent().append(newSel);

    }


</script>
<script>
    //绑定change事件
    $("select[name=type_id]").change(function(){
        //获取type id
        var type_id=$(this).val();
        $.ajax({
             type : "GET",
             url : "<?php echo U('ajaxGetAttr','',FALSE); ?>/type_id/"+type_id,
            dataType : "json",
            success : function(data)
            {
               var html="";
               $(data).each(function(k,v)
               {
                 if(v.attr_type =='可选')
                  {
                      html+='<li><input type="hidden" name="attr_id[]" value="'+v.id+'" ><a href="javascript:void(0);" onclick="addNewli(this)">[+]</a>';
                  }
                   html+=v.attr_name+"：";
                 if(v.attr_type_value !="")
                   {
                       var _arr=v.attr_type_value.split(",");
                       html+="<select name='goods_attr[]'> <option>请选择</option>";
                        for(var i=0;i<_arr.length; i++)
                       {
                           html+="<option value='"+_arr[i]+"'>"+_arr[i]+"</option>";
                       }
                       html+="</select>";
                   }else
                      html+="<input type='text' name='goods_attr[]' />";
                   html+='</li>';
               });
                //把拼接好的字符串放在下面
              $('#attr_list').html(html);
            }
        });

    });

    //[+]的函数
  function addNewli(a)
  {
      var li=$(a).parent();

      if($(a).html()=='[+]')
      {
          var newli=li.clone();
          li.after(newli);
          newli.find('a').html('[-]');
      }else
          li.remove();
  }

    $('#tabbar-div p span').click(function(){
        var i=$(this).index();
        $('._tab_content').hide();
        //显示对应的table
        $('._tab_content').eq(i).show();
        $('#tabbar-div p span').removeClass('tab-front').addClass('tab-back');
        $('#tabbar-div p span').eq(i).removeClass('tab-back').addClass('tab-front');

    });

</script>


<div id="footer">
    共执行 7 个查询，用时 0.028849 秒，Gzip 已禁用，内存占用 3.219 MB<br />
    版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>