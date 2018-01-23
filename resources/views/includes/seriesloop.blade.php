@foreach($ganre_list as $genre)
    @if($genre['series'])

        <h2>{{ $genre['genre']->name }}</h2>

        <div class="contain movies_slider">
            <i class="glyphicon glyphicon-chevron-left scroll_row_left_icon"></i>
            <div class="row scroll_row">
                <div class="row__inner">

                    @foreach($genre['series'] as $series)

                        <div class="tile">
                            <a href="{{ route('series', $series->slug) }}">
                                <div class="tile__media">
                                    <img class="tile__img" src="{{ asset('assets/images/' . $series->poster) }}" alt=""  />
                                </div>
                                <div class="tile__details">
                                    <div class="tile__title">
                                        {{$series->name}}
                                    </div>
                                </div>
                            </a>
                        </div>

                    @endforeach

                </div>
            </div>
            <i class="glyphicon glyphicon-chevron-right scroll_row_right_icon"></i>
        </div>
    @endif
@endforeach