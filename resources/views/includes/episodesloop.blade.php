

@foreach($episode->chunk(3) as $items)
    <div class="row">
        @foreach($items as $sode)
            <div class="col-md-3">

                <img src="{{ asset('assets/images/' .$sode->episode_thumbnail)}}" class="img-responsive m-b-5" alt="" />

                <div class="title pull-left">{{ $sode->episode_name }}</div>

            </div>

        @endforeach
    </div>
@endforeach

