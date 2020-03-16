<script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
<script src="{{url('assets/js/main.js')}}"></script>
<script src="{{url('assets/js/bootstrap.min.js')}}"></script>


<script src="{{url('assets/js/lib/data-table/datatables.min.js')}}"></script>
<script src="{{url('assets/js/lib/data-table/dataTables.bootstrap.min.js')}}"></script>
<script src="{{url('assets/js/lib/data-table/dataTables.buttons.min.js')}}"></script>
<script src="{{url('assets/js/lib/data-table/buttons.bootstrap.min.js')}}"></script>
<script src="{{url('assets/js/lib/data-table/jszip.min.js')}}"></script>
<script src="{{url('assets/js/lib/data-table/vfs_fonts.js')}}"></script>
<script src="{{url('assets/js/lib/data-table/buttons.html5.min.js')}}"></script>
<script src="{{url('assets/js/lib/data-table/buttons.print.min.js')}}"></script>
<script src="{{url('assets/js/lib/data-table/buttons.colVis.min.js')}}"></script>
<script src="{{url('assets/js/init/datatables-init.js')}}"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<!-- Sweetalert -->
<!-- <script src="https://cdn.jsdelivr.net/sweetalert2/6.4.1/sweetalert2.js"></script> -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script>
<script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<script>
        CKEDITOR.replace( 'editor1' );
</script>
<script type="text/javascript">
    $(document).ready(function() {
      $('#bootstrap-data-table-export').DataTable();
  	});
  	/* Datatable */
    $(function() {
      $('#tagTable').DataTable({
        "order": [[ 1, "DESC" ]]
      });
      $('#newsTable').DataTable({
        "order": [[ 3, "DESC" ]]
      });
    });

    function inputName() {
            var title = $(document).find("#inputTagName").val();
            // console.log(title);
            $(document).find("#inputTagMetaTitle").val(title);
            $(document).find("#inputTagSlug").val(slugify(title));
            // document.getElementById("productTitleGoogle").textContent = title;
            // document.getElementById("inputTagSlug").textContent = slugify(title);
            // document.getElementById("seo_url_format").val(title);
        }
    function slugify(text)
        {
          return text.toString().toLowerCase()
            .replace(/\s+/g, '-')           // Replace spaces with -
            .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
            .replace(/\-\-+/g, '-')         // Replace multiple - with single -
            .replace(/^-+/, '')             // Trim - from start of text
            .replace(/-+$/, '');            // Trim - from end of text
        }
    $('document').ready(function()
    {
        $('textarea').each(function(){
                $(this).val($(this).val().trim());
            }
        );
    });

    $('select').selectpicker();

    function deleted_item( id, track )
    {

      var dataObj       = {};
      dataObj.id        =  id;
      dataObj.track     =  track;
      if( id != null)
      {
        dataObj.id     =  id;
      }
      swal({
        title: "Are you sure?",
        text: "You will not be able to recover this imaginary file!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel plx!",
        closeOnConfirm: false,
        closeOnCancel: false
      },
      function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                  url: $('#hf_base_url').val() + '/ajax/delete-item',
                  type: 'GET',
                  cache: false,
                  datatype: 'json',
                  data: {data:dataObj},
                  headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
                  success: function(data)
                  {
                    if(data.delete == true)
                    {
                      swal({
                        title: 'Deleted',
                        text: 'Your selected item deleted.',
                        type: 'success',
                        timer: 2000,
                        showCancelButton: false,
                        showConfirmButton: false
                      },
                      function(){ 
                           location.reload();
                       }
                      );
                    }                    
                  },
                  
                  error:function(){}
            });            
        } else {
          swal("Cancelled", "Your imaginary file is safe :)", "error");
        }
      });
    }
</script>