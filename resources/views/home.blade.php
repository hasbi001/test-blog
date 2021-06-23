@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row position-relative form">
        <div class="col-md-3">
            <label>Job Description</label>
            <input type="text" id="jobdes" class="form-control" />
        </div>
        <div class="col-md-3">
            <label>Location</label>
            <input type="text" id="location" class="form-control" />
        </div>
        <div class="col-md-2">
            <div class="form-check position-absolute bottom-0">
              <input class="form-check-input" type="checkbox" value="Full Time" name="fulltime" id="fulltime">
              <label class="form-check-label" for="fulltime">
                Full Time
              </label>
            </div>
        </div>
        <div class="col-md-1">
            <button class="btn btn-primary position-absolute bottom-0" onclick="Search()">Search</button>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Job List</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="content-jobs">
                        <div id="list-jobs"></div>
                        <input type="hidden" id="page" value="1">
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="btn btn-primary" onclick="loadmore()">Load More ...</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    
    $(document).ready(function() {
        var page = $("#page").val();
        var jobdes = $("#jobdes").val();
        var location = $("#location").val();
        var fulltime = "";
        loadJobs(page,jobdes,location,fulltime);
    });
    function  Search() {
        $('.isi-jobs').remove();
        var page = $("#page").val();
        var jobdes = $("#jobdes").val();
        var location = $("#location").val();
        var fulltime = $('input[name="fulltime"]:checked').val();
        loadJobs(page,jobdes,location,fulltime);
    }

    function loadmore() {
        var page = parseInt($("#page").val());
        var jobdes = $("#jobdes").val();
        var location = $("#location").val();
        var fulltime = $('input[name="fulltime"]:checked').val();
        page = page + 1;
        loadJobs(page,jobdes,location,fulltime);
        $("#page").val(page);
    }

    function loadJobs(page,jobdes,location,fulltime) {
        
        $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
          method: "POST",
          url: "{{ route('jobs') }}",
          data:{
            page: page,
            jobdes: jobdes.toLowerCase(),
            location: location.toLowerCase(),
            fulltime: fulltime
          },
          dataType:'JSON',
          success: function (e) {
            // aler(e)
            console.log(e.status);
            if (e.status == 'failed') {
                alert('No Job listed');
            }
            else
            {
                $('#list-jobs').prepend(e.result);    
            }
            
          }
        });
    }
</script>
@endsection
