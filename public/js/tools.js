var $j = jQuery.noConflict();

$j( function() {
    $j(".date").datepicker({
        dateFormat: "yy-mm-dd"
    });
} );

$j( document ).ready(function() {
    $j( ".project" ).click(function() {
        var id = $j(this).attr('data-id');
        if($j(this).attr('data-method') == 'Kanban'){
            $j('.sprint').html('');
            loadDashboardById(id);
        }else{
            loadSprintByProjectId(id);
        }

    });
});

function loadDashboardById(id){
    $j.ajax({
        url: "dashboard/"+id ,
        success: function(result){
            $j('.dashboard').html(result);
            loadDetails();
        }
    });
}

function loadSprintByProjectId(id){
    $j.ajax({
        url: "dashboard/sprint/"+id,
        success: function(result){
            $j('.sprint').html(result);
            $j( ".sprint-button" ).click(function() {
                $j.ajax({
                    url: "dashboard/sprint/ticket/"+$j(this).attr('data-id') ,
                    success: function(result){
                        $j('.dashboard').html(result);
                        loadDetails();
                    }
                });
            });
        }
    });
}

function setStatus(){
    $j( ".status-button" ).click(function() {
        $j.ajax({
            url: "dashboard/api/edit/ticket/"+$j('.ticket').attr('data-id')+"/status/"+$j(this).attr('data-status') ,
            success: function(result){
                $j.ajax({
                    url: "dashboard/sprint/ticket/"+result ,
                    success: function(result){
                        $j('.dashboard').html(result);
                        loadDetails();
                    }
                });
            }
        });
    });

}

function loadDetails(){
    setStatus();
    $j( ".details" ).click(function() {
        $j.ajax({
            url: "dashboard/api/details/"+$j(this).attr('data-id') ,
            success: function(result){
                $j('.col-details').html(result);
            }
        });
    });
}
