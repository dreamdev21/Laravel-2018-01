<!-- Updates from Subscriptions -->
<style>
    #hideMe {
        -moz-animation: cssAnimation 0s ease-in 10s forwards;
        /* Firefox */
        -webkit-animation: cssAnimation 0s ease-in 10s forwards;
        /* Safari and Chrome */
        -o-animation: cssAnimation 0s ease-in 10s forwards;
        /* Opera */
        animation: cssAnimation 0s ease-in 10s forwards;
        -webkit-animation-fill-mode: forwards;
        animation-fill-mode: forwards;
    }
    @keyframes cssAnimation {
        to {
            width:0;
            height:0;
            overflow:hidden;
        }
    }
    @-webkit-keyframes cssAnimation {
        to {
            width:0;
            height:0;
            visibility:hidden;
        }
    }

</style>
                <div class="content-block" {{--id="hideMe"--}}>
                    <div class="showHideNotes">
                    </div>
                    <div class="cb-header">
                        <div class="row">
                            <div class="col-lg-10 col-sm-10 col-xs-10">
                                <ul class="list-inline">

                                </ul>
                            </div>
                            
                        </div>
                    </div>
                    <div class="cb-content avatars">
                        <div class="row follow_not_area">
 
                        </div>
                    </div>
                </div>


<script>
    if(!localStorage.getItem('noty_area')){
        setTimeout(function () {


            $('.follow_not_area div').each(function(){
                $(this).remove();
            })

            localStorage.setItem('noty_area', true);
        },10000);
    }

</script>
<!-- /Updates from Subscriptions -->