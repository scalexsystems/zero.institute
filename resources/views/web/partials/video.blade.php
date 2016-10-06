@section('after-body')
    <!--Script stops video from playing when modal is closed-->
    <script>
        $('#video-model').on('hidden.bs.modal', function (e) {
            var embed = $('.embed-responsive-item');
            var src = embed.attr('src');
            e.preventDefault();
            embed.attr('src', src);
        });
    </script>
@endsection

<div id="video">
    <a href="#" role="button" aria-haspopup="true" class="btn btn-video" title="Watch the video" id="watch-video"
       data-toggle="modal" data-target="#video-model">
        Watch Video &nbsp; <i class="fa fa-play"></i>
    </a>

    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="#watch-video" aria-hidden="true"
         id="video-model">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="embed-responsive embed-responsive-16by9">
          <span class="sr-only" itemscope itemtype="http://schema.org/VideoObject">
            <span itemprop="name">Scalex Zero</span><br>
            <link itemprop="contentUrl" href="https://www.youtube.com/watch?v=iV7idUln3_E">
            <time itemprop="duration" content="PT00H00M55S">00:00:55</time><br>
            <img itemprop="thumbnailUrl" src="https://img.youtube.com/vi/BVZ1_QtQBk4/0.jpg" alt="Scalex Zero"><br>
            <span itemprop="uploadDate">2016-08-17</span><br>
            <span itemprop="description">Scalex Zero is a web and mobile enabled platform to assist institutions providing higher education in administrative activities.</span>
          </span>
                    <iframe class="embed-responsive-item" src="//www.youtube.com/embed/iV7idUln3_E?html5=1"
                            frameborder="0"
                            allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
