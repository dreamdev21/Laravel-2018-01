@foreach($ganre_list as $genre)

    @if($genre['movies'])

    <h2>{{ $genre['genre']->name }}</h2>

    <div class="contain movies_slider">
        <i class="glyphicon glyphicon-chevron-left scroll_row_left_icon"></i>
        <div class="row scroll_row iescrollstyle">
            <div class="row__inner">
    @foreach($genre['movies'] as  $movie)

        @if($movie->type == 'movie')


                <div class="tile
                @if(!empty($movie->trailer))
                        play_trailer
                    @endif
                " data-id="{{$movie->id}}">
                    @if(!empty($movie->trailer))
                        <video class="trailer_video" >
                        </video>
                        @endif
                    <a href="{{ route('movie', $movie->slug) }}">
                    <div class="tile__media">
                        <img class="tile__img" src="{{ asset('assets/images/' . $movie->poster) }}" alt=""  />
                    </div>
                    <div class="tile__details">
                        <div class="tile__title">
                            {{$movie->title}}
                        </div>
                    </div>
                    </a>
                </div>

        @endif
    @endforeach

            </div>
        </div>
        <i class="glyphicon glyphicon-chevron-right scroll_row_right_icon"></i>
    </div>
    @endif
@endforeach