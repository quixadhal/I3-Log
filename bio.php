<?php
$time_start = microtime(true);
require_once 'site_global.php';
require_once 'navbar.php';
require_once 'random_background.php';

$SNOWY_IMG              = "$URL_HOME/gfx/snowy.jpg";
$SCOOGE_IMG             = "$URL_HOME/gfx/scooge.png";
$ME_IMG                 = "$URL_HOME/gfx/me.jpg";
$GOLD_IMG               = "$URL_HOME/gfx/gold.png";

$SCOOGE_URL             = "$URL_HOME/data/scooge.pdf";
$GOLD_URL               = "$URL_HOME/data/gold.pdf";

?>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="cache-control" content="no-cache" />
        <meta http-equiv="pragma" content="no-cache" />
        <title>Who The Fuck?</title>

        <link rel="stylesheet" href="<?php echo $SITE_GLOBAL_CSS;?>">
        <link rel="stylesheet" href="<?php echo $BACKGROUND_CSS;?>">

        <style>
            .body {
                overflow-x: hidden;
                overflow-y: hidden;
            }
            ::-webkit-scrollbar {
                display: none;
            }
            ::-webkit-scrollbar-track {
                display: none;
            }
            ::-webkit-scrollbar-thumb {
                display: none;
            }
            #background-div {
                opacity: 1.00;
            }
            #portraits-div {
                display: flex;
                flex-direction: row;
                flex: 1;
                height: 150px;
                justify-content: center;
                object-fit: contain;
                background-color: rgba(0,0,0,0.6);
                column-gap: 30px;
            }
            #bio-div {
                display: none;
                position: absolute;
                top: 20%;
                left: 20%;
                font-family: 'Lato', sans-serif;
                font-size: <?php echo $BIG_FONT_SIZE; ?>;
                width: 60%;
                padding: 20px 20px 20px 20px;
                box-sizing: content-box;
                background-color: rgba(0,0,0,0.8);
                text-align: left;
                text-indent: 5ch;
                border-radius: 20px;
                -webkit-border-radius: 20px;
                -moz-border-radius: 20px;
            }
            #corner-log-div {
                display: none;
                position: absolute;
                bottom: 0;
                right: 0;
            }
        </style>

        <script src="<?php echo $JQ;?>"></script>
        <script src="<?php echo $JSCOOKIE;?>"></script>
        <script src="<?php echo $JSRANDOM;?>"></script>
        <script src="<?php echo $JSMD5;?>"></script>
        <script src="<?php echo $MOMENT;?>"></script>
        <script src="<?php echo $MOMENT_TZ;?>"></script>
        <script src="<?php echo $SITE_GLOBAL_JS;?>"></script>
        <script src="<?php echo $BACKGROUND_JS;?>"></script>
        <script src="<?php echo $NAVBAR_JS;?>"></script>

        <script language="javascript">
            var currentBackground = $("#background-img").attr("src");
            var snowyBackground = "<?php echo $SNOWY_IMG;?>";

            $(document).ready(function() {
                //randomizeBackground();
                $("#background-img").attr("src", snowyBackground);
                showDiv('bio-div');
                showDiv('corner-log-div');
            });
        </script>
    </head>
    <body bgcolor="<?php echo $BGCOLOR; ?>" text="<?php echo $TEXT; ?>" link="<?php echo $UNVISITED; ?>" vlink="<?php echo $VISITED; ?>">
        <div id="background-div">
            <img id="background-img" src="<?php echo $BACKGROUND_URL; ?>" />
        </div>
        <div id="portraits-div">
            <img id="scooge-img" src="<?php echo $SCOOGE_IMG;?>" />
            <img id="quix-img" src="<?php echo $ME_IMG;?>" />
            <img id="gold-img" src="<?php echo $GOLD_IMG;?>" />
        </div>
        <div id="bio-div">
            <p>
                Mental Illness is an insidious thing.  The seeds of it can be
                sown years, or even decades before they blossom.  The person who
                suffers from it may not even smell the fragrance, even though
                others around them wrinkle their nose whenever they're nearby.
            </p>
            <p>
                We humans have brains that evolved to be very good at pattern
                recognition, and because of this we try really hard to fit
                everything around us into nice neat and tidy categories.  You
                are a child, or an adult, based on your age crossing a magic
                threshold value of 18 or 21.  Everyone agrees that there are
                15-year-olds who are mature, and 30-year-olds who are childlike
                and foolish, yet we are compelled to draw that line.
            </p>
            <p>
                Likewise, we like to think that we are either sane, or crazy.  If
                you act like everyone else, you are considered sane.  If you act
                oddly, we start to wonder and nudge you towards that other category.
                But like almost everything in nature, it's not binary, and it can
                change and evolve over time.
            </p>
            <p>
                Many would say "seek treatment!"  Like most diseases, that's a good
                choice if you catch things early on.  But think about what "treatment"
                means.  Part of it is therapy, which tries to build up the ego and
                convince the patient that they can get better, and that they SHOULD
                get better.  Part of it is also mixing chemicals into the brain to
                shuffle things around and hope that a more normal pattern can be
                established without destroying the person inside.  But, after one
                lives with something for decades, it become entwined with who they
                are and is not so easy to unravel.  To quote Pink Floyd, "There's
                someone in my head, but it's not me", is often the outcome.
            </p>
            <p>
                I promised to tell my "origin" story, and so this is that, for
                whatever it's worth.  The pictures at the top are (or were) my
                family.  <a href="<?php echo $SCOOGE_URL;?>">Scooge</a> is the cute 19-year-old
                kitten on the left, and her 18-year-old son with the bowl of ice
                water on the right is <a href="<?php echo $GOLD_URL;?>">Gold</a>.
                The ugly bag of mostly water in the middle is me.  I'm going to
                focus on me, since I've already told the story of how Scooge showed
                up during a blizzard and forced her way inside, years ago.
            </p>
            <p>
                I guess I still hold out hope that someone will adopt my cats before
                it's too late, and that's why I showed them again.  I deserve my
                fate, but they don't.  The day I have to walk out, they're going
                to either be euthanized, or die slowly in a shelter.  Do something
                for them, if you can.  If it's past April 25th, it's too late.
            </p>
            <h1> <font color="yellow"> Growing Up </font> </h1>
            <p>
                I grew up in a small town in southwest Michigan.  I was born at
                5:30 in the morning in the summer of 1969, and that probably explains
                why I hate mornings.  The first 4 years of my life are a blur.  No,
                literally!  According to my Mom, I was a quiet but overly bright
                child, and my first word was "pretty", as I pointed to a broach she
                was wearing.  I guess I had no reason to speak before that.
            </p>
            <p>
                Nobody knew my eyesight was terrible under I was learning to write
                and kept drawing the lowercase d wrong, putting the line through the
                middle of the circle, instead of on the side.  I remember being
                very confused by this, as I KNEW how it was supposed to go, I put
                my face down to the paper, drew it, and then looked and it was wrong.
                Apparently, my eyes were crossing and my brain would flip between
                the left and right perspectives, screwing me up with the parallax.
            </p>
            <p>
                So, a bit later I had eye surgery to correct that issue and got
                fitted with nice thick coke-bottle glass lenses to correct the
                near-sightedness and astigmatism I also had.  This would have a
                minor impact on my social life going forward, but I didn't know
                that yet.
            </p>
            <p>
                I had a pretty normal childhood after that.  I made friends.  I
                ran around.  I got bullied.  I laughed and cried.  I excelled in
                school, aside from PE as I was a bit weak and sickly, having been
                born prematurely AND inheriting some Irish blood that made me
                crisp up under the sun like a piece of bacon in the frying pan.
            </p>
            <p>
                I found a best friend in 4th grade, and we hung out together all
                the time.  Life was pretty good.  We used to race home after school
                to watch the most amazing cartoon on TV, Star Blazers!  This was
                before the era of VCRs, and before the word "anime" existed.  To
                us, it was just a really cool show about spaceships.
            </p>
            <p>
                At this point, there was talk about bumping me up a grade.  In a
                small town, there was no such thing as "advanced placement" anything,
                so the only option was to advance a grade early, or just slog through
                and when we ran off the end of the textbooks, they'd have to make
                stuff up for us to keep busy.
            </p>
            <h1> <font color="yellow"> The First Nail</font> </h1>
            <p>
                The first seed of my future mental illness was probably planted
                right here, in the middle of 5th grade.  They had opted to not
                advance me a grade, and so while I was happy to be with my friends,
                I was also BORED.  But that wasn't the problem.  The problem was
                that I was about to experience a new emotion, one that I reacted
                to very poorly, and that would cripple my development for years
                to come.
            </p>
            <p>
                About a third of the way into 5th grade, we got two new transfer
                students.  One from California, and one from Georgia.  They were
                both nice guys.  The guy from California was a funny guy, class
                clown material just like I was.  He fit into our group of friends
                right away, and was super popular.  The other kid was a bit more
                unusual, having some southern traits that we though were "weird".
                The most obvious thing was that he hugged people to greet them.
                Nothing wrong with that back in the late 1970's, except that it
                wasn't normal for Michigan.
            </p>
            <p>
                Anyways, as time passed, I noticed my best friend was spending
                more and more time with the new kid from California, and often
                he'd want to hang out with him instead of me.  You can see where
                this is going.  Jealousy is such a stupid and petty emotion, but
                I'd never felt it before, and all I knew was that it made me feel
                angry.  As a child, I transferred that anger towards the new kid,
                and as you probably guessed, there was a showdown.  I basically
                threw a fit and told my best friend to pick:  him or me.  Of
                course, as any SANE person would do, he chose the guy NOT acting
                crazy.
            </p>
            <p>
                Here's where the fun part comes into play.  Feeling betrayed and
                dejected, I did what any class clown archetype character would do,
                I started trying to make others laugh.  And one of the things I
                did was write a short story about the OTHER new kid, and about
                how weird he was.  It worked.  Lots of my classmates laughed.
                One of them asked if I could make them a copy, and then my teacher
                saw it.  She did not laugh.
            </p>
            <p>
                If you didn't grow up in a small midwestern town, in the late
                1970's with proper Christian values, like I did.  This next part
                may confuse you.  But because I'd basically mocked this kid and
                called him "gay" for going around hugging everyone, the adults
                had a genuine concern that I might be gay.  And at that time, lots
                of adults believed that homosexuality was a disease that needed
                to be cured, so it didn't spread to others.
            </p>
            <p>
                And so, I would be called down to the Principal's office every day
                for weeks on end, to "discuss" things, while they tried to decide
                if I should get "treatment", or be expelled, or whatever needed
                to be done to protect all the other children from the imaginary
                threat their Bibles said I might pose.  In the end, it was decided
                I just needed to apologize to him and that was officially the end
                of it.  But the damage was done.
            </p>
            <p>
                I had learned that being creative and drawing attention to myself
                was a terrible thing that I should never, ever, ever, do again.
                And all my classmates knew I was some kind of horrible person for
                some reason they didn't understand, but nobody would be called
                to the Principal's office so often unless they did something
                really horrible!  So, of course I was shunned.
            </p>
            <p>
                The next two years saw me try my best to be invisible.  I did my
                school work, I went home, I read books.
            </p>
            <h1> <font color="yellow"> The Second Nail</font> </h1>
            <p>
                I'll take a brief aside here, to set up a bit more of the
                environment for the story.  My family was not wealthy by
                any stretch of the imagination, but we weren't poor either.
                We were what was once called "lower middle class", meaning
                we had enough to get by and replace our cars every 4 or 5
                years, and take a vacation once in a while.  I was an only
                child, and my birthday was conveinently 6 months away from
                Christmas, so those expenses were spread out too.
            </p>
            <p>
                My parents were great.  My Mom was supportive and encouraged
                me to do whatever I wanted.  My Dad was stoic, and while he
                very rarely ever said anything positive, he also rarely punished
                me, other than with looks of disapproval.  Looking back now,
                I know he was proud of me (he died before shit really hit the
                fan for me), and that he just didn't quite know how to relate
                to a bookworm son, rather than the son he'd expected to take
                hunting and fishing all the time.
            </p>
            <p>
                Unfortunately, to a young kid, this seemed like nothing I did was
                ever good enough.  Instead of slight praise, I got "You almost
                did good there.  If you try harder, next time you can nail it!"
                I know it was meant to encourage me to give it my all, but it
                instead made me not really want to try at all.  It's a fine line,
                and nobody wants to get "participation trophies", but each kid will
                react differently... and for quiet kids, it can be pretty hard to
                tell if they're thinking about how to do better, or just quietly
                giving up.
            </p>
            <h1> <font color="yellow"> The Third Nail</font> </h1>
            <p>
                Middle school was my opportunity to start over, or so I hoped!
                You have to realize that in a small town, it's not like you can
                ever really start over.  There aren't enough people to ever get
                lost in the crowd or escape your past... but hey, I had hope!
            </p>
            <p>
                I had decided to join the band, and had made some new friends
                over the summer during band camp, and had endured the taunting
                by a few others as well.  And as the new year started, I tried
                a bit too hard to make friends.  What I mean by that, is that I
                was DESPERATE to find new friends.  I missed having someone to
                hang out with outside of school, and so I committed another cardinal
                sin.  I pandered.
            </p>
            <p>
                Because I'd isolated myself, I wasn't very good at reading people.
                My poor eyesight didn't make this any easier, but really it was me
                staying isolated that made it so I didn't pick up on the non-verbal
                cues that my classmates were already using and learning.  THEY, on
                the other hand, could read me like a book.  So, it didn't take long
                for a few of them to see how desperate I was, and start manipulating
                me so that I'd end up agreeing with them to try and gain their
                friendship, and then have them use that to turn other friends
                against me.  You know the drill here: "Don't you think Bob is weird?"
                "Hey Bob, Chris just said you were weird!"
            </p>
            <p>
                Being the class clown didn't help me much here either, since we
                didn't really have fixed classes anymore.  We didn't have a
                "homeroom" the way some schools did, we just had 7 class periods
                each day with lunch in the middle, and some classes were staggered
                as MWF or TR.  And so, my already poor social skills would degrade
                even further as I developed a reputation for being two-faced, and
                a loner, and a weirdo.  Back to the books I went.
            </p>
            <h1> <font color="yellow"> High School </font> </h1>
            <p>
                By this point, you can probably tell that things won't really get
                much better in the foreseeable future.  I will say that I actually
                enjoyed 11th grade.  10th grade was just the same as Middle School
                for me.  Since I'd been tromping back and forth between the two
                buildings to take 10th grade classes anyways (best our school could
                do for overly smart people), it was in 11th grade I got to take
                vocational electronics with a teacher who was a TV repair guy.
            </p>
            <p>
                Not only was this hands-on education fun, but I was fairly good at
                it, and would turn it into a very short-lived career between the end
                of high school and the end of college.  Sadly, the world was moving
                in the direction of replacing whole circuit boards for $300, rather
                than finding the $0.55 diode that had burnt out, and by the time
                I was out of college, it was nearly impossible to fix anything
                without specialized equipment AND the ability to order parts from
                the factory.
            </p>
            <p>
                So, the last two years of High School could have been really good
                for me, but I'd already had some apathy set in.  I stopped trying
                to really study, since I saw no point in it, and I was smart
                enough to ace the SAT exams without trying, which got me into
                college -- even though it didn't get me any scholarships which
                I really COULD have gotten had I tried.
            </p>
            <h1> <font color="yellow"> College, the Fourth Nail </font> </h1>
            <p>
                In many ways, college started out like Middle School had.  I was
                looking forward to an actual real fresh start without any baggage
                dragged along from my old school life.  I didn't know that I already
                had packed heavy bags that I was carrying, but most of us don't
                realize that until it's too late.
            </p>
            <p>
                My first semester was abysmal.  My assigned college roommate and
                I did not get along at all, as he was a "prep" kid who was obsessed
                with looking good, being trendy, and trying to impress the ladies.
                By this time, I was playing video games, listening to heavy metal and
                classic Rock (NOT what was popular at the time), and looking like
                a bum.  The real issue though, was my grades.
            </p>
            <p>
                You may recall me saying I aced the SAT and was used to not having
                to try, at all.  Well, I let them place me in several advanced
                classes because I tested so well.  CHEM 102 would be a wake-up call.
                Advanced Chemistry was interesting, and I did pretty well until about
                halfway through the semester, when we got to thermodynamics.  At
                that point, the professor started writing equations with these
                weird delta symbols I'd never seen before, and I swiftly fell behind
                just trying to figure out what the hell was going on.
            </p>
            <p>
                Thermodynamics, as you probably know, uses quite a bit of calculus
                to show rates of change as reactions occur.  I didn't take calculus.
                I hadn't taken pre-calc.  I hadn't even bothered with Algebra 3.  So,
                I found myself suddenly having to learn a whole new language, and
                the best I could manage was to squeak a D out of it by the end of the
                semester.  It never even occurred to me that the smart thing to do
                would have been to withdraw from the class and take it later, or
                take the lower-level version...
            </p>
            <p>
                Why did I relate this to you guys?  Because it's an example of a
                mindset that I had, and that many people have.  It's called the local
                maximum problem, or as Bilbo said in The Hobbit, thinking you're
                at the top of the tallest tree, because all the trees around you are
                shorter than yours.
            </p>
            <p>
                Having grown up as one of the smartest kids in a small town, I was
                now just a bit above average in a much larger school full of the
                smart kids from lots of towns.  Whoops!
            </p>
            <p>
                So, I kind of got my shit together, and after a couple years too
                many, got a degree in Computer Science, and had to give up on
                the degree I wanted to get in English too.  Yes, I was also taking
                creative writing and had about 2/3 of that degree done, but I
                wasn't making enough money at my part-time job, nor could my
                parents afford to keep me in school, so... out into the workplace
                I went.
            </p>
            <p>
                I should probably mention that I did have a short romantic
                relationship towards the end of my time there, which ended badly,
                and since she was the vindictive type with a lawyer Father, it
                did a good job of crushing my ego and convincing me that I would
                never have a relationship again.  This is where the Fourth Nail got
                driven home, more than anywhere else.
            </p>
            <h1> <font color="yellow"> Work! </font> </h1>
            <p>
                I always hated interviews.  They are the pinnacle of social
                encounters, placing the job seeker in the position of desperation
                and expecting them to read all the social cues and hints given off
                by the high-and-mighty employer, who in turn will be reading you
                with years of experience and trying to hold a poker face.
            </p>
            <p>
                For me, this isn't just nervousness.  It's the culmination of ALL
                my failures over my lifetime.  I'm literally, at least in my head,
                being judged for my lack of social skills and banished for being
                uncertain, shy, or just not liked.  Despite this, I did manage to
                land a few jobs over the next 10 years or so.  This was back before
                automated resume filters, where you could talk to humans and even
                visit the offices to do an interview in person and show that you
                might not be quite as worthless as you look on paper, or sound over
                the phone.
            </p>
            <p>
                I like to think I was a good worker.  I was never a leader, even if
                I did lead a few design teams with my ideas.  I never got fired.
                Oddly though, almost every company I worked for did end up failing,
                and that's usually why I left.  I was either laid off, or one of the
                ones turning the lights off when they closed up.
            </p>
            <p>
                During these years, I enjoyed working.  I learned quickly as needed.
                I did my best to do my work on time, staying late if I needed to,
                and trying to help people around me if I could.  I got along with
                most of my co-workers.  I made a decent wage and felt reasonably
                content.  I made the mistake of buying a house with a couple friends,
                and that would end up biting me in the ass when that friendship
                mostly failed... but I also had enough money and was hopeful enough
                about my future that I didn't even care too much.  I assumed I would
                continue improving and let it go.
            </p>
            <h1> <font color="yellow"> The Fifth Nail </font> </h1>
            <p>
                After the last real company I worked for went belly up, I decided
                to take a short break from working.  I had money in the bank, and
                a solid work history.  I figured I'd take a year off to do a
                vacation somewhere, and also do some home improvements.  Back then,
                I was in my mid 30's and still had energy and wasn't afraid to climb
                up on the roof, or run wiring through the walls.  What I didn't know
                was that the tech economy in my area was in full collapse.
            </p>
            <p>
                The tech bubble had burst a couple years earlier, but these things
                take a while to have impacts in places that aren't big cities.  And
                right when I decided to take time off, that was when all the tech
                companies around me decided to shut down their local branch offices
                and move to the east coast, or the west coast.  My short break was
                about to become a bit longer...
            </p>
            <p>
                I started looking for work again, but didn't find much.  This didn't
                bother me though, as I foolishly believed I had plenty of time and
                two falsehoods that are obvious in hindsight.  First, that the
                skills I had learned would still be valuable a few years later, and
                second that my resume entries wouldn't depreciate almost as fast
                as a new car being driven off the dealer's lot.
            </p>
            <p>
                Turns out that not only does the tech world throw away old knowledge
                and only values shiny and new, but if you are not currently employed,
                many employers will auto-bin your resume on the spot, and many will
                expect a gap of just a month or two at most before trashing it.  This
                was also the start of the online application period, where resumes
                were beginning to be auto-trashed by buzzword filters.  Not knowing
                this, I wasn't worried and carried on until the hammer fell again.
            </p>
            <p>
                I had mentioned a falling out with my friends, and this coincided
                with another unhappy event.  To get a break from the conflict, I
                visited my Mom and discovered that she was actually in much worse
                shape than she'd let on.  To the point that I felt obligated to
                move in and help her with all the things she wasn't able to do
                anymore.  Since I wasn't working, and wasn't overly happy at home,
                this sounded like a good idea at the time.
            </p>
            <p>
                It turned out, this was the Fifth Nail.  Not only did her condition
                continue to deteriorate, but my ability to find contract work did too.
                I had to spend more time taking care of her as the years rolled over,
                and less time doing anything meaningful in my career.  In 2016, she
                passed away from multiple organ failure, and I had a big empty
                house, no job, and not a clue what the hell I was going to do.  BAM!
            </p>
            <h1> <font color="yellow"> The Last Nail </font> </h1>
            <p>
                After some time to mourn, and some more time to think, I decided
                I wanted to sell the house and move somewhere new, for that last
                fresh start opportunity.  Because those had worked so well for me
                in the past, right?  Yeah... well... I still had hope at this point.
            </p>
            <p>
                I figured out my expenses for living where I was, and came up with
                a budget, and then started researching places to move to.  I expected
                to find a job in 6 months (HAHAHA!), so I had to make sure I had
                enough money to pay my lease AND living expenses for at last that
                long, and I was running out of time, since my savings was dwindling
                and until I moved, I couldn't really sell the house.
            </p>
            <p>
                I was tired of dealing with snow.  I had developed far-sightedness
                from age that worked well with my near-sightedness, to make it so
                I couldn't see shit anymore.  Over the years, I'd been in a few
                accidents, including one where I pulled out in front of someone
                that I couldn't see because of the sun AND the position of another
                car that was turning.  I also never liked driving in heavy multi-lane
                traffic (grew up in a small town with dirt roads, remember?), and
                so my criteria included a city with mass transit so I didn't need
                to drive.  Seattle seemed like a perfect choice!
            </p>
            <p>
                On paper, it was perfect.  Nice climate.  No snow.  Reputation for 
                being cloudy and raining all the time.  Elaborate bus and light
                rail system.  TONS of tech jobs.  And I could afford it until the
                house sold and/or I got a job.  So, I sold my cars, rented an SUV,
                packed up the cats and my computers, and some other crap, and got
                a shiny apartment on the 17th floor of a high-rise, right in the
                middle of downtown Seattle.  WOOT!
            </p>
            <p>
                I even got to meet Kalinash and Cratylus during in that early
                time.  They might remember me.  I think I was pretty positive back
                then, and maybe I made an OK impression as a weird guy, but not a
                terrible monster.  At least I hope so.  They were both nice people
                and I'm happy to have gotten to meet them.
            </p>
            <p>
                As part of my plan to move, I started doing "power walks" around my
                neighborhood in Kalamazoo, knowing I'd be walking everywhere in
                the new city, and that they had actual hills there.  And after
                moving, I continued this, trying to gradually expand the radius
                around my apartment that I was familiar with.  In late 2017, the
                downtown was a bit rough, but not horrible yet.  And in 2018, it
                was still pretty acceptable for a big city.  I, however, had some
                health issues cropping up.
            </p>
            <p>
                Gout is a hereditary disease that's related to arthritis.  Nobody
                knows the cause, but an imbalance of uric acid in the blood will
                trigger a flareup.  What happens is that when you have protein
                chains floating around in your blood (purines), and your uric acid
                level gets too high, the acid will crystalize out along those
                proteins and form little stalgtites in your joints.  Your immune
                system sees this as an attack and sends the white blood cell
                calvary to go kill it.
            </p>
            <p>
                However, crystals are not alive.  So, the white blood cells Kamakaze
                onto the sharp crystals and your immune system says "OH SHIT!  Send
                MOAR troops to the front!"  And so, your joint swells bigger and
                bigger, becoming so tender that the wind blowing on it is painful.
                Wearing shoes is utterly unthinkable, and even trying to put a sock
                on so you can use crutches to go outside is agony.  This lasts
                anywhere from 3 days to 3 weeks.  Yeah, I had that happen several
                times over the next couple years, and the more I tried to walk and
                exercise, the more often they seemed to happen.
            </p>
            <p>
                In 2020, I got to enjoy the best of Seattle.  As the epicenter of
                COVID-19 in the US, the city was turned into a ghost town.  I have
                some pictures of 2nd and Pine at 2PM, where it'd normally be bumper-
                to-bumper and the streets were empty.  Lots of small stores closed
                then, since there were no customers to keep them afloat.
            </p>
            <p>
                As if that wasn't enough, we then had the George Floyd BLM riots.
                Culminating in cars being set on fire, hundreds of businesses having
                their windows smashed (including my apartment building), and the
                infamous CHOP zone, where an entire section of the city was blocked
                off and taken over by protestors, kicking the police out and having
                armed guards deciding who could enter and leave.  It was at this
                point I decided to move to Bellevue.
            </p>
            <p>
                And that brings us to the final few years of the story.  After moving,
                I felt hopeful again for a short time.  I still didn't have a job,
                but the environment was less depressing and felt healthy again.  I
                had given up on trying to get into better physical shape, and while
                this meant I was tired all the time and never felt "good", it also
                meant fewer gout outbreaks.  I started sending out resumes and
                actually trying again.
            </p>
            <p>
                The world had continued to change around me though.  Recruiters no
                longer filled the role they used to.  Last time I'd used them, they
                would work to find you a job and bypass a lot of the automated
                filtering for you.  Now, however, recruiters have jobs THEY want to
                fill, and will basically only push your resume to THOSE jobs.  Add
                to this the concept of "ghost jobs", where employers post openings
                they don't intend to fill, or leave already filled postings up just
                to collect resumes for future use.
            </p>
            <p>
                And I won't lie.  I'm old.  My brain is not as fast as it was 20
                years ago.  I get confused more easily.  I am depressed and afraid
                all the time, because of my perpetual failures.  My skills are not
                useful in today's world, and nobody will give me a chance to learn
                anything new unless I can do it on my own dime, in a vacuum.  I am
                dead broke, and am being evicted onto the streets 6 months sooner
                than I expected, due to a legal maneuver that short-circuits the
                trial and forces a default judgement on me.  As I write this,
                I have 6 days left.
            </p>
            <p>
                I'm not looking for pity.  What I'd really like is for someone
                to rescue my elderly cats, so they don't die alone and terrified
                in a shelter.  They are the closest thing to children I will ever
                have, and it breaks my heart to let them down like this... but I'm
                afraid my mental illness has blossomed.
            </p>
            <p>
                I can't honestly say when it went from being just simple depression
                to being crippling.  It's in my head, after all, and thus it changes
                how I view the world around me.  But there's no denying it.  I still
                believe I could function and perform as an acceptable worker if I
                had the chance, but I lack the ability to find that job... and as
                someone else said, the job fairy isn't going to fly by and drop one
                in my lap for me.
            </p>
            <p>
                So, there you have it.  The Pathetic Story of Dread Quixadhal.  I
                hope you enjoyed wasting your time reading this as much as I did
                trying to write it down.  I don't know if I said anything of value,
                but I think I may have imparted a few useful lessons on things to
                avoid for your own children's lives.  At the very least, I hope you
                got to see how my illness crept up on me slowly without me being
                aware of it for a long time, and then with me denying it even
                after it was obvious to others around me.  That's often how it
                happens, not with a bang, but with a whimper.
            </p>
            <p>
                <font color="lightgreen">
                PS:  For all those who did try to help me, thank you.  I am deeply
                sorry if my brain mis-interpreted your gestures as mocking, or
                condescending, or just flat-out cruel.  That's how I see the world.
                </font>
            </p>
            <p>
                Enjoy your bright capitalist future!  Don't be a Quix!
            </p>
            <h1> <font color="red"> 永遠にさようなら </font> </h1>
            <a href="<?php echo $DOWNLOAD_URL; ?>">
                <tt><?php system("/bin/ls -lhG --time-style=\"+%Y-%M-%d %H:%M:%S\" $FILE_HOME/data/i3log.sql.xz | /usr/bin/colrm 1 18"); ?></tt>
            </a>
            <br />
            <a href="<?php echo $VM_URL; ?>">
                <tt>&nbsp;<?php system("/bin/du -shL --time --time-style=\"+%Y-%M-%d %H:%M:%S\" $FILE_HOME/../stuff/WileyMUD/"); ?></tt>
            </a>
            <div id="corner-log-div">
                <img class="nav-img glowing" id="navbar-button-themudorg" title="I3 Log Page" src="<?php echo $LOG_ICON; ?>" onclick="window.location.href='<?php echo $LOG_URL; ?>';" />
            </div>
        </div>
    </body>
</html>
