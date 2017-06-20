<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?=Yii::$app->user->identity->username;?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => 'Menu Yii2', 'options' => ['class' => 'header']],
                    //['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii']],
                    //['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug']],

                    //['label' => 'Sign out (' . Yii::$app->user->identity->username . ')','url' => ['/user/security/logout'],'linkOptions' => ['data-method' => 'post']],

                    ['label' => 'Students Management', 'icon' => 'fa fa-file-code-o', 'url' => ['/students']],
                    ['label' => 'Course Management', 'icon' => 'fa fa-file-code-o', 'url' => ['/classes']],
                    ['label' => 'Subject Management', 'icon' => 'fa fa-file-code-o', 'url' => ['/subjects']],
                    ['label' => 'Chapter Management', 'icon' => 'fa fa-file-code-o', 'url' => ['/subject-chapters']],
                    ['label' => 'Chapter Videos Management', 'icon' => 'fa fa-file-code-o', 'url' => ['/videos']],
                    ['label' => 'Test Management', 'icon' => 'fa fa-file-code-o', 'url' => ['/tests']],
                    ['label' => 'Test Questions Management', 'icon' => 'fa fa-file-code-o', 'url' => ['/test-questions']],
                    ['label' => 'Student Test Details', 'icon' => 'fa fa-file-code-o', 'url' => ['/student-tests']],
                    ['label' => 'Notification Message', 'icon' => 'fa fa-file-code-o', 'url' => ['/fcm-devices/send-message']],

                    ['label' => 'Student Subscription Management', 'icon' => 'fa fa-file-code-o', 'url' => ['/student-subscriptions']],
                    ['label' => 'Subscription Management', 'icon' => 'fa fa-file-code-o', 'url' => ['/subscription-plans']],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    
                ],
            ]
        ) ?>

    </section>

</aside>
