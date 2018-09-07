



/*编辑文档*/

function addTag () {
  let name = $('#tagnameinput').val();
  if (name !== '') {
    let html = '<div class="mdui-chip mdui-m-r-1">\
    <input type="hidden" name="tag[]" value="' + name + '" />\
  <span class="mdui-chip-title">' + name + '</span>\
  <span class="mdui-chip-delete"><i class="mdui-icon material-icons">cancel</i></span>\
</div>'
    $('#taglist').append(html);
    $('#tagnameinput').val('');
  } else {
    mdui.snackbar('请输入标签名称', {position: 'left-bottom'})
  }
}
$(function(){
  $('#addtagbtn').on('click', function(){
    addTag();
  });
  $('#taglist').on('click', '.mdui-chip .mdui-chip-delete', function () {
    $(this).closest('.mdui-chip').remove();
  });

})