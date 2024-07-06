<section class="site-section pt-5 pb-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="owl-carousel owl-theme home-slider">
                    <?php
                    $sql = "SELECT * FROM b_post WHERE hot = 1";
                    $hotPosts = $db->getList($sql);

                    foreach ($hotPosts as $hot) {
                        echo '<div>
                        <a href="blog-single.html" class="a-block d-flex align-items-center height-lg" style="background-image: url(' . $hot['thumbnail'] . '); ">
                          <div class="text half-to-full">
                            <span class="category mb-5">Food</span>
                            <div class="post-meta">
                              <span class="author mr-2"><img src="images/person_1.jpg" alt="Colorlib"> Colorlib</span>&bullet;
                              <span class="mr-2">' . $hot['created_time'] . '</span> &bullet;
                              <span class="ml-2"><span class="fa fa-comments"></span> 3</span>
                            </div>
                            <h3>' . $hot['title'] . '</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem nobis, ut dicta eaque ipsa laudantium!</p>
                          </div>
                        </a>
                      </div>';
                    }

                    ?>

                </div>
            </div>
        </div>
    </div>
</section>