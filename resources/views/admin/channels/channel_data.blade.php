<div class="panel panel-default">

            <h2 class="panel-heading">Channel Data</h2>
            <div class="panel-body">
                <table class="table table-striped table-flip-scroll cf">
                    <thead class="table-header">
                        <th>Logo</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Url</th>
                        <th>Select Category</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <img class="channel_thumb" src="{{$data['channel_thumb']}}" >
                            </td>
                            <td style="width:20%" class="channel_title">
                                {{ $data['channel_title'] }}
                            </td>
                            <td valign="bottom" class="channel_description">
                                {{ substr(strip_tags( $data['channel_description']), 0, 50 ) }}{{ strlen(strip_tags( $data['channel_description'])) > 50 ? "..." : ""  }}
                            </td>
                            <td class="channel_url">
                                {{  $data['channel_url'] }}
                            </td>
                            <td>
                                <select name="category_id"  class="channel_category">
                                    @foreach ($data['channelCategories'] as $channelCategory)
                                        <option value="{{$channelCategory->id}}">{{$channelCategory->name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <p>
                                    <button class="btn btn-xs btn-danger add_channel" id="{{$data['channel_id']}}">Add</button>
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <h2 class="panel-heading">Video Data</h2>

            <div class="panel-body">
                <table class="table table-striped table-flip-scroll cf">
                    <thead class="table-header">
                        <th>Title</th>
                        <th>Description</th>
                        <th>Url</th>
                    </thead>
                    <tbody>
                    @foreach ($data['channel_videos'] as $video)
                        <tr>
                            <input class="channel_id" type="hidden" value="{{$video->snippet['channelId']}}">
                            <td style="width:20%" class="video_title">
                                {{ $video->snippet['title'] }}
                            </td>
                            <td valign="bottom" class="video_description">
                                    {{ substr(strip_tags($video->snippet['description']), 0, 50 ) }}{{ strlen(strip_tags($video->snippet['description'])) > 50 ? "..." : ""  }}
                            </td>
                            <td class="video_url">
                                    {{ $video->url }}
                            </td>
                            <td>
                                <p>
                                    <button class="btn btn-xs btn-danger add_video" id="{{$video->id}}">Add</button>
                                    {{--<a href="{{ route('channels.show', $channel->id) }}" class="btn btn-xs btn-success delete"> View</a>--}}
                                </p>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{csrf_field()}}
            </div>
</div>

