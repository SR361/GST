<div class="card-header" style="display: <?php if($delete_row == '0' && $add_row == '0'){ echo "none"; } ?>">
          <?php if($delete_row == '1'){ ?>
          <input type="submit" name="submit" id="del_btn" value="{{ trans('app.Delete') }}" class="btn btn-danger btn-sm pull-left"/>
          <?php } ?>
          <?php if($add_row == '1'){ ?>
          <a href="#" class="btn btn-success btn-sm pull-right" onclick="open_add_modal();">{{ trans('app.Add') }}</a>
          <?php } ?>
        </div>

        className: '<?php if($excel == '0'){ echo 'd-none'; } ?>',


        extend: 'colvis',
          className: '<?php if($col_visible == '0'){ echo 'd-none'; } ?>',
          columns: <?php if($delete_row == '0' && $update_row == '0'){ echo '[1,2,3]'; }else{ echo '[1,2,3,4]'; } ?>,
          text:"{{ trans('app.Column visibility') }}"

          {
          "targets": [ 0 ],
          "visible": '<?php if($delete_row == '0'){ echo false; }else{ echo true; } ?>'
        }

        {
          "targets": [ 4 ],
          "visible": '<?php if(in_array('4', $array_check) || ($delete_row == '0' && $update_row == '0')){ echo false; }else{ echo true; } ?>',
          "searchable": '<?php if(in_array('4', $array_check)){ echo false; }else{ echo true; } ?>'
        }