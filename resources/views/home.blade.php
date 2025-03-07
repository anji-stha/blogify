@extends('layouts.main')
@section('content')
    @include('message')
    {{-- <div class="card">
        <p> Simplicity is the essence of happiness. - Cedric Bledsoe </p>
        Don't be a slave to you mind,
        Make your mind your slave.
    </div> --}}

    <!-- container starts -->
    <div class="container container-flex">
        <main role="main">

            <article class="article-featured">
                <h2 class="article-title">Finding simplicity in life</h2>
                <img src="https://raw.githubusercontent.com/kevin-powell/reponsive-web-design-bootcamp/master/Module%202-%20A%20simple%20life/img/life.jpg"
                    alt="simple white desk on a white wall with a plant on the far right side" class="article-image">
                <p class="article-info">July 23, 2019 | 3 comments</p>
                <p class="article-body">Life can get complicated really quickly, but it doesn't have to be! There are
                    many ways to simplify your life, a few of which we've explored in the past. This week we're taking a
                    bit of a approach though, in how you can find simplicity in the life you already living.</p>
                <a href="#" class="article-read-more">CONTINUE READING</a>
            </article>

            <article class="article-recent">
                <div class="article-recent-main">
                    <h2 class="article-title">Keeping cooking simple </h2>
                    <p class="article-body">Food is a very important part of everyone's life. If you want to be healthy,
                        you have to eat healthy. One of the easiest ways to do that is to keep your cooking nice and
                        simple.</p>
                    <a href="#" class="article-read-more">CONTINUE READING</a>
                </div>
                <div class="article-recent-secondary">
                    <img src="https://raw.githubusercontent.com/kevin-powell/reponsive-web-design-bootcamp/master/Module%202-%20A%20simple%20life/img/food.jpg"
                        alt="two dumplings on a wood plate with chopsticks" class="article-image">
                    <p class="article-info">July 19, 2019 | 3 comments</p>
                </div>
            </article>

            <article class="article-recent">
                <div class="article-recent-main">
                    <h2 class="article-title">Simplicity and work </h2>
                    <p class="article-body">Work is often a major source of stress. People get frustrated, it ruins
                        their relationship with others and it leads to burnout. By keeping your work life as simple as
                        possible, it will help balance everything out.</p>
                    <a href="#" class="article-read-more">CONTINUE READING</a>
                </div>
                <div class="article-recent-secondary">
                    <img src="https://raw.githubusercontent.com/kevin-powell/reponsive-web-design-bootcamp/master/Module%202-%20A%20simple%20life/img/work.jpg"
                        alt="a chair white chair at a white desk on a white wall" class="article-image">
                    <p class="article-info">July 12, 2019 | 3 comments</p>
                </div>
            </article>

            <article class="article-recent">
                <div class="article-recent-main">
                    <h2 class="article-title">Simple decorations</h2>
                    <p class="article-body">A home isn't a home until you've decorated a little. People either don't
                        decorate, or they go overboard and it doesn't have the impact they were hoping for. Staying
                        simple will help draw the eye where you want it to and make things pop like never before.</p>
                    <a href="#" class="article-read-more">CONTINUE READING</a>
                </div>
                <div class="article-recent-secondary">
                    <img src="https://raw.githubusercontent.com/kevin-powell/reponsive-web-design-bootcamp/master/Module%202-%20A%20simple%20life/img/work.jpg"
                        alt="a green plant in a clear, round vase with water in it" class="article-image">
                    <p class="article-info">July 3, 2019 | 3 comments</p>
                </div>
            </article>
        </main>

        <aside class="sidebar">

            <div class="sidebar-widget">
                <h2 class="widget-title">ABOUT ME</h2>
                <img src="https://raw.githubusercontent.com/kevin-powell/reponsive-web-design-bootcamp/master/Module%202-%20A%20simple%20life/img/about-me.jpg"
                    alt="john doe" class="widget-image">
                <p class="widget-body">I find life better, and I'm happier, when things are nice and simple.</p>
            </div>

            <div class="sidebar-widget">
                <h2 class="widget-title">RECENT POSTS</h2>
                <div class="widget-recent-post">
                    <h3 class="widget-recent-post-title">Keeping cooking simple</h3>
                    <img src="https://raw.githubusercontent.com/kevin-powell/reponsive-web-design-bootcamp/master/Module%202-%20A%20simple%20life/img/food.jpg"
                        alt="two dumplings on a wood plate with chopsticks" class="widget-image">
                </div>
                <div class="widget-recent-post">
                    <h3 class="widget-recent-post-title">Simplicity and work</h3>
                    <img src="https://raw.githubusercontent.com/kevin-powell/reponsive-web-design-bootcamp/master/Module%202-%20A%20simple%20life/img/work.jpg"
                        alt="a chair white chair at a white desk on a white wall" class="widget-image">
                </div>
                <div class="widget-recent-post">
                    <h3 class="widget-recent-post-title">Simple decorations</h3>
                    <img src="https://raw.githubusercontent.com/kevin-powell/reponsive-web-design-bootcamp/master/Module%202-%20A%20simple%20life/img/deco.jpg"
                        alt="a green plant in a clear, round vase with water in it" class="widget-image">
                </div>
            </div>

        </aside>

    </div>
@endsection
