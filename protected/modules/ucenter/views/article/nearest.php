<ul class="breadcrumb">
    <li><a href="/">首页</a> > </li>
    <li><a href="<?php echo __APP__?>/ucenter/article/type">文章分类</a>>最近操作的文章</li>
</ul>
<div class="alert alert-info" style="margin-left:17px;margin-right: 17px;margin-bottom:14px;display: none;">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>操作成功！</strong>
</div>
<!--列表详情层-->
<div class='m_listwraper'>
    <div class="m_typebox noborder">
                <table class="table">
                    <tr class="info">
                        <td>文章ID</td>
                        <td>文章标题</td>
                        <td>更新时间</td>
                        <td>发布人</td>
                        <td>操作</td>
                    </tr>
                    <?php if(empty($archives)):?>
                    <tr>
                        <td colspan="5" style="text-align:center;">还没有最近操作的文章^~^</td>
                    </tr>
                    <?php endif;?>
                    <?php foreach($archives as $archive):?>
                    <tr style="width: 100%;">
                        <td><?php echo $archive['id']?></td>
                        <td><?php echo $archive['title']?></td>
                        <td><?php echo $archive['lastpost'] ? date("Y-m-d H:i",$archive['lastpost']) : '<font color="green">最新发布</font>'?></td>
                        <td><?php echo $archive['uname']?></td>
                        <td>
                            <a href="<?php echo __APP__?>/home/article/?aid=<?php echo $archive['id'];?>" target="_blank">预览</a> 
                            <a href="<?php echo __APP__?>/ucenter/article/editarticle?typeid=<?php echo $archive['typeid']?>&arcid=<?php echo $archive['id'].'?'.rand(0,99);?>">修改</a> 
                            <a href="#changetype" id="<?php echo $archive['id']?>" data-toggle="modal" class="changetype">移动</a> 
                            <a href="<?php echo __APP__?>/ucenter/article/delarticle?typeid=<?php echo $archive['typeid'];?>&arcid=<?php echo $archive['id'];?>" onclick="return confirm('确定删除本条记录？');">删除</a> 
                        </td>
                    </tr>
                    <?php endforeach;?>
                </table>
    </div>
</div>
<!--列表详情层END-->

<!--修改文章所属分类Start-->
<div id="changetype" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">修改文章分类</h3>
  </div>
  <div class="modal-body">
      <input type="hidden" name="arcid">
      <p>
          移动到：
          <select name="pid">
              <option value="0">栏目获取中...</option>
          </select>
      </p>
 </div>
  <div class="modal-footer">
      <button class="btn" data-dismiss="modal" aria-hidden="true" id="closetype">关闭</button>
    <button class="btn btn-primary" id="subtype">提交</button>
  </div>
</div>
<!--修改文章所属分类END-->
<script>
    $('.changetype').click(function(){
        var aid = $(this).attr('id');
        var html = '<option value="0" depth="0">请选择</option>';
        var url = '<?php echo __APP__?>/ucenter/article/type';
        $('input:[name=arcid]').attr('id',aid);
        $.ajax({
            type: 'POST',
            url : url,
            data : {'flag':'api'},
            success:function(rs){
                for (var i in rs){
                    html += '<option value="'+rs[i].id+'.'+rs[i].depth+'">'+padMark(rs[i].typename,'&emsp;',rs[i].depth)+'</option>';
                }
                $('select[name="pid"]').html(html);
            },
            dataType:'JSON'
        });
    });
    //提交修改
    $('#subtype').click(function(){
        var arcid = $('input:[name=arcid]').attr('id');
        var typeid = $('select[name=pid]').val();
        var url  = '<?php echo __APP__?>/ucenter/article/changetype';
        if(typeid==0) return;
        $.post(url,{'arcid':arcid,'typeid':typeid},function(rs){
            console.log(rs);
            if(rs=='ok'){
                window.location.reload();
                alert('移动成功');
            }else if(rs=='deny'){
                alert('没有权限');
            }
        });
    });
    //填充字符
    function padMark(str,mark,num){
        var oldstr = str;
        for(var i=0;i<num;i++){
            oldstr =mark+oldstr;
        }
        return oldstr;
    }
</script>
