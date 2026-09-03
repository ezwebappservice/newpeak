<!-- ===== Hero Section ===== -->
<section class="hero school-page-hero parents-hero">
  <div class="container">
    <div class="row school-hero-row">
      <!-- Left column -->
      <div class="col-lg-7 school-hero-copy">
        <p class="hero-eyebrow">FOR STUDENTS</p>
        <h1 class="hero-heading">
          Help Your Child<br> Thrive In Life,<br>
          <span class="accent">Not Just In Exams.</span><br>
        </h1>


        <p class="hero-text">
          We help children break screen addiction, manage emotions, improve behaviour and build the inner skills they need for <b class="accent"> better academics and a successful life.</b>
        </p>

           <div class="hero-features for-school-features for-students-features">
          <div class="hero-feature">
            <span class="icon-circle">
              <img src="<?= peak_img('students/phone-addict.png') ?>" alt="">
              <!-- <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="4" width="18" height="13" rx="2"/><path d="M8 21h8M12 17v4"/></svg> -->
            </span>
            <span class="label">Break Screen<br>Addiction</span>
          </div>
          <div class="hero-feature">
            <span class="icon-circle">
              <img src="<?= peak_img('students/human-brain.png') ?>" alt="">
              <!-- <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 18h6M10 21h4M12 3a6 6 0 00-4 10.5c.5.5.8 1 .8 1.7V16h6.4v-.8c0-.7.3-1.2.8-1.7A6 6 0 0012 3z"/></svg> -->
            </span>
            <span class="label">Better Behaviour <br> & Emotional Control</span>
          </div>
          <div class="hero-feature">
            <span class="icon-circle">
              <img src="<?= peak_img('students/goal.png') ?>" alt="">
              <!-- <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg> -->
            </span>
            <span class="label">Stronger Focus &<br>Better Habits</span>
          </div>
          <div class="hero-feature">
            <span class="icon-circle">
              <img src="<?= peak_img('students/bar-chart1.png') ?>" alt="">
              <!-- <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg> -->
            </span>
            <span class="label">Better Academic<br>Performance</span>
          </div>
        </div>

      </div>

    </div>
  </div>
  <div class="hero-visual school-hero-visual school-students-hero">
    <div class="hero-dots"></div>
    <div class="hero-ring"></div>
    <div class="hero-circle">
      <img src="<?= peak_img('FOR STUDENTS.png') ?>" alt="Students participating in a school program">
    </div>
  </div>


<?= view('partials/peak_stats_bar') ?>
</section>

<!-- ===== Parent value strip ===== -->
<section class="parents-value-strip" aria-label="Parent program benefits">
  <div class="container">
    <div class="parents-value-layout">
      <span class="parents-value-heart" aria-hidden="true">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M20.8 5.8a5.2 5.2 0 0 0-7.4 0L12 7.2l-1.4-1.4a5.2 5.2 0 0 0-7.4 7.4L12 22l8.8-8.8a5.2 5.2 0 0 0 0-7.4Z"/></svg>
      </span>
      <div class="parents-value-message">
        <h2>We don’t just motivate children’s.</h2>
        <p>We transform patterns that hold them back.</p>
      </div>
      <div class="parents-value-items">
        <div class="parents-value-item"> <img src="<?= peak_img('students/brain.png') ?>" alt="Emotional Resilience">  <p>Emotional <br>Resilience</p></div>
        <div class="parents-value-item"> <img src="<?= peak_img('students/idea.png') ?>" alt="Mental Agility"> <p>Mental <br>Agility</p></div>
        <div class="parents-value-item"> <img src="<?= peak_img('students/comment.png') ?>" alt="Clear Communication"> <p>Clear <br>Communication</p></div>
        <div class="parents-value-item"> <img src="<?= peak_img('students/rupee.png') ?>" alt="Financial Intelligence"> <p>Financial <br>Intelligence</p></div>
      </div>
    </div>
  </div>
</section>



<!-- ===== Student programs ===== -->
<section class="parent-programs" aria-labelledby="parent-programs-title">
  <div class="container">
    <header class="parent-programs-heading">
      <p>Our Programs for Students</p>
      <h2 id="parent-programs-title">Two Powerful Programs. <span>Real Transformation.</span></h2>
      <div>Choose the format that fits your child's needs.</div>
    </header>
    <div class="parent-programs-grid">
      <article class="parent-program-card">

        <div class="flex">
          <span class="parent-program-icon">▣</span>
          <div class="second-section">
            <h3>Student Workshop</h3>
            <strong class="parent-program-format">Online &nbsp;•&nbsp; 1:1 Session</strong>
          </div>
        </div>
        

        <div class="parent-program-details"><b>◷ &nbsp;60 Minutes</b><span><strong>&#8377;599</strong>Per Student</span></div>
        <p>A focused 60-minute session that helps students understand themselves, break unhealthy patterns and build essential life skills.</p>
        <h4>Students will learn to:</h4>
        <ul>
          <li><img src="<?= peak_img('comment1.png') ?>" alt=""> Understand self &amp; build self-belief</li>
          <li> <img src="<?= peak_img('comment1.png') ?>" alt=""> Break screen addiction &amp; distraction loops</li>
          <li><img src="<?= peak_img('comment1.png') ?>" alt=""> Build focus, habits &amp; self-discipline</li>
          <li><img src="<?= peak_img('comment1.png') ?>" alt=""> Make smart choices for their future</li>
          <li><img src="<?= peak_img('comment1.png') ?>" alt=""> Introduction to financial awareness</li>
        </ul>
        <a href="<?= peak_enquiry_url() ?>" class="parent-program-button">Book Student Workshop <span>&rarr;</span></a>
      </article>
      <article class="parent-program-card parent-program-card--gold">
        <div class="flex">
            <span class="parent-program-icon">▦</span>
            <div class="second-section">
              <h3>5-Day Student Boot Camp</h3>
              <strong class="parent-program-format">Online &nbsp;•&nbsp; 5 Days Intensive Program</strong>
            </div>  
        </div>
       

        <div class="parent-program-details"><b>◷ &nbsp;1 Hour Session<br><small>for 5 Days</small></b><span><strong>&#8377;5,999</strong>Per Student</span></div>
        <em class="parent-program-tag">Deep Learning. Real Practice. Lasting Change.</em>
        <p>An immersive 5-day experience that creates deep, lasting change through practice, reflection and real-life application.</p>
        <h4>Students will experience:</h4>
        <ul>
          <li><img src="<?= peak_img('comment1.png') ?>" alt=""> Stronger self-belief &amp; self-awareness</li>
          <li><img src="<?= peak_img('comment1.png') ?>" alt=""> Break screen addiction &amp; build self-control</li>
          <li><img src="<?= peak_img('comment1.png') ?>" alt=""> Emotional resilience &amp; stress management</li>
          <li><img src="<?= peak_img('comment1.png') ?>" alt=""> Confidence &amp; communication mastery</li>
          <li><img src="<?= peak_img('comment1.png') ?>" alt=""> Financial intelligence for real-life</li>
          <li><img src="<?= peak_img('comment1.png') ?>" alt=""> Memory booster techniques</li>
          <li><img src="<?= peak_img('comment1.png') ?>" alt=""> Habit design &amp; accountability</li>
          <li><img src="<?= peak_img('comment1.png') ?>" alt=""> Personal action plan for long-term success</li>
        </ul>
        <a href="<?= peak_enquiry_url() ?>" class="parent-program-button">Book 5-Day Boot Camp <span>&rarr;</span></a>
      </article>
    </div>
  </div>
</section>

<!-- ===== Parent outcomes ===== -->
<section class="parent-outcomes" aria-labelledby="parent-outcomes-title">
  <div class="container">
    <div class="parent-outcomes-panel">
      <h2 id="parent-outcomes-title">What You Will Gain</h2>
      <div class="parent-outcomes-grid">
        <div> <img src="<?= peak_img('students/atom.png') ?>" alt="Science-Backed"> <p>Science-Backed<br>Psychology & Tools</p></div>
        <div> <img src="<?= peak_img('students/screen.png') ?>" alt="Screen Addiction"> <p>Screen Addiction &amp;<br>Prevention & Recovery</p></div>
        <div> <img src="<?= peak_img('students/consumer-behaviour.png') ?>" alt="Behaviour Change"> <p>Behaviour Change &amp;<br>Tools & Strategies</p></div>
        <div> <img src="<?= peak_img('students/notes.png') ?>" alt="Practical, Experiential"> <p>Practical, Experiential<br>& Activity-Based</p></div>
        <div> <img src="<?= peak_img('students/bar-chart.png') ?>" alt="Measurable Progress"> <p>Measurable Progress<br>&amp; & Parent Reports</p></div>
        <div> <img src="<?= peak_img('students/security-system.png') ?>" alt="Safe, Supportive"> <p>Safe, Supportive &amp;<br>1:1 Environment</p></div>
      </div>
    </div>
  </div>
</section>

<!-- ===== Parent program differentiators ===== -->
<section class="parent-unique" aria-labelledby="parent-unique-title">
  <div class="container">
    <div class="parent-unique-panel">
      <h2 id="parent-unique-title">THE IMPACT YOUR CHILD WILL SEE</h2>
      <div class="parent-unique-grid">
        <div> <img src="<?= peak_img('students/smile.png') ?>" alt="Calmer Mind & Better Emotions">  <p>Calmer Mind & Better Emotions</p></div>
        <div> <img src="<?= peak_img('students/target.png') ?>" alt="Stronger Focus & Discipline"> <p>Stronger Focus & Discipline</p></div>
        <div> <img src="<?= peak_img('students/dance.png') ?>" alt="Better Behaviour & Confidence"> <p>Better Behaviour & Confidence</p></div>
        <div> <img src="<?= peak_img('students/book.png') ?>" alt="Better Memory & Academic Performance"> <p>Better Memory & Academic Performance</p></div>
        <div> <img src="<?= peak_img('students/star.png') ?>" alt="Future-Ready Skills for Life"> <p>Future-Ready Skills for Life</p></div>
      </div>
    </div>
  </div>
</section>

<!-- ===== Parent program call to action ===== -->
<section class="parent-program-cta" aria-label="Choose a parent program">
  <div class="container">
    <div class="parent-program-cta-panel">
      
      <h2>Give your child the skills school doesn’t teach,<br>but life absolutely demands.<br><span>Invest in their inner strength today.</span></h2>
      <div class="parent-program-cta-actions">
        <div>
          <a href="<?= peak_enquiry_url() ?>" class="parent-program-cta-button">Book Parent Workshop <span>&rarr;</span></a>
          <small> <span>60 Minutes </span> | <span>₹599 Per Student</span> </small>
        </div>
        <div>
          <a href="<?= peak_enquiry_url() ?>" class="parent-program-cta-button parent-program-cta-button--gold">Book Parent Boot Camp <span>&rarr;</span></a>
          <small> <span>1 Hour/Day for 5 Days</span></span> | <span>₹5,999 Per Student</span> </small>
        </div>
       
      </div>
    </div>
  </div>
</section>
