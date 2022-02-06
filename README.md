
## CI Global Calendar Project - V2.0

<a href="https://travis-ci.com/davide-casiraghi/movement_meets_life_nova"><img src="https://travis-ci.org/davide-casiraghi/movement_meets_life_nova.svg" alt="Build Status"></a>
[![Quality Score](https://img.shields.io/scrutinizer/g/davide-casiraghi/movement_meets_life_nova.svg?style=flat-square)](https://scrutinizer-ci.com/g/davide-casiraghi/movement_meets_life_nova)
[![Coverage Status](https://scrutinizer-ci.com/g/davide-casiraghi/movement_meets_life_nova/badges/coverage.png?b=main)](https://scrutinizer-ci.com/g/davide-casiraghi/movement_meets_life_nova/)
<a href="https://codeclimate.com/github/davide-casiraghi/movement_meets_life_nova/maintainability"><img src="https://api.codeclimate.com/v1/badges/0d0b577b4f4ca8dd9a18/maintainability" /></a>

The project is developed using Laravel 8 PHP framework.

The dev environment it's a Laravel Homestead virtual machine. (Vagrant)


## Contributing

### Development workflow
- The **master** branch represent the production environment.
- The **dev** brench represent the developent environment.

- To start a new feature, checkout a new git branch called **feature/*** from **dev**.
- To create a fix, checkout a new git branch called **fix/*** from **dev**.


### Access to the virtual machine database

You can access to the homestead database using **MySQLWorkbench** or **Sequel Ace**
(Sequel Ace is the "sequel" to longtime macOS tool Sequel Pro.)

I suggest to use **Sequel Ace** instead of **Sequel Pro** since **Sequel Pro** may have problems connecting to the Homestead database.

Connect using SSH and this parameters:

```
MySQL host: 127.0.0.1
Database user: homestead
Database password: secret
Database: homestead

SSH host: 192.168.10.10 (unless you changed it in Vagrantfile)
SSH user: vagrant
SSH password: vagrant
```

Then create the database **movement_meets_life**

### Setup the dev environment

Clone this repo into a local folder:
```
git clone git@github.com:davide-casiraghi/movement_meets_life_nova.git
```

Copy & customize your .env config:   
```cp .env.example .env```    
```nano .env```


Config the .env like this:
```
DB_CONNECTION=mysql
DB_HOST=192.168.10.10
DB_PORT=3306
DB_DATABASE=movement_meets_life
DB_USERNAME=homestead
DB_PASSWORD=secret
```


Add configuration to the Homestead.yaml file:
```
cd ~/Homestead  
sudo nano Homestead.yaml  

```
And here add:
```yaml
folders:
    - map: .... absolute path of the local folder related to your git repo...
      to: /home/vagrant/code/movement_meets_life_nova
      
sites:
    - map: movement_meets_life_nova.local
      to: /home/vagrant/code/movement_meets_life_nova/public
      php: "8.0"
```

To start the virtual machine:
```
cd ~/Homestead  
vagrant up
```

Install vendor files:   
```composer install```

Generate a unique app key by the following command:    
```php artisan key:generate ```  
The key will be added to your .env file:
```APP_KEY=```

Run the db migrations:    
```php artisan migrate```

Clean the cache:  
```php artisan cache:clear```

Open the hosts file on your machine in your text editor and add this entry.

```192.168.10.10 movement_meets_life_nova.local```

Install all npm modules:   
```npm install```

Create the file storage symbolic link from public/storage to storage/app/public

```php artisan storage:link```

Access the local website at:   
[https://movement_meets_life_nova.local/](https://movement_meets_life_nova.local/)

### Code analysis
Static code analysis:   
```./vendor/bin/phpstan analyse```   
or, in case of errors:   
```./vendor/bin/phpstan analyse --memory-limit=2G```

PHP Insights:   
```php artisan insights```


### Testing

```php artisan test```

To check the code coverage:
1) Connect to the vagrant machine with `vagrant ssh`
2) Enable Xdebug with `xon` (Homestead by default have Xdebug off)
3) Generate the code coverage report: `./vendor/bin/phpunit --coverage-html=html`
4) Disable Xdebug with `xoff`

You can find now the code coverage in the /html directory.

If you have any error:
- change the xdebug config file on Homestead:  (These settings are for Xdebug 3.0)
  ```sudo nano /etc/php/8.0/fpm/conf.d/20-xdebug.ini```
  add
```
zend_extension=xdebug.so
xdebug.mode=coverage
xdebug.discover_client_host = 1
xdebug.client_port = 9000
xdebug.max_nesting_level = 512
xdebug.log = /var/log/php8.0-fpm.log
xdebug.log_level = 7
```
- then start Xdebug:
```
sudo phpenmod xdebug
sudo service php8.0-fpm restart
```

If you still have errors you can try to add also:
```
xdebug.client_host = 192.168.10.1
xdebug.start_with_request = yes
```

### Testing emails
- Create an account on Mailtrap
- Add the data to the .env file

## Code Static Analysis
Code static Analysis is provided by PHPStan.
Run using:
```./vendor/bin/phpstan analyse```

### Maintenance mode

To put the website in maintenance:   
```php artisan down --render="maintenance"```

To restore it:   
```php artisan up```

### Staging server

TBD

### Generate dummy data
If you are using PHPStorm you can generate Dummy data with this plugin:

[https://plugins.jetbrains.com/plugin/14957-laravel-tinker](https://plugins.jetbrains.com/plugin/14957-laravel-tinker)

Once the plugin is installed in phpstorm.
1) From the console empty the database and run the seeders   
   ```php artisan migrate:fresh && php artisan db:seed```
2) Press ctrl+Shift+T
3) Paste the following code
4) Press again  ctrl+Shift+T to execute the code

```php
<?php
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\EventRepetition;
use App\Models\Organizer;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Statistic;
use App\Models\Teacher;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Venue;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Sequence;

$user = User::factory()->create([
    'email' => 'davide.casiraghi@gmail.com',
]);
$details = UserProfile::factory()->create([
    'user_id' => $user->id,
    'name' => 'Davide',
    'surname' => 'Casiraghi',
    'country_id' => 214,
]);
$user->profile()->save($details);
$user->assignRole('Super Admin');
$user->setStatus('enabled');


User::factory()->count(4)->create()->each(function($user) {
    $details = UserProfile::factory()->create([
        'user_id' => $user->id,
        'country_id' => rand(1,240),
    ]);
    $user->assignRole('Registered');

    $statuses = ['enabled','disabled'];
    $random_status = array_rand($statuses, 1);
    $status = $statuses[$random_status];
    $user->setStatus($status);
});

PostCategory::factory()->create(['name' => 'Calendar articles']);
PostCategory::factory()->count(10)->create();

$post = Post::factory()->create(['title' => 'The project','category_id' => 1]);
$post = Post::factory()->create(['title' => 'Terms of use','category_id' => 1]);
$post = Post::factory()->create(['title' => 'Contact Improvisation Global Archive (CIGA)','category_id' => 1]);
$post = Post::factory()->create(['title' => 'Donate','category_id' => 1]);
$post = Post::factory()->create(['title' => 'Privacy Policy','category_id' => 1]);
$post = Post::factory()->create(['title' => 'Get Involved','category_id' => 1]);
$post = Post::factory()->create(['title' => 'Help - How to insert contents','category_id' => 1]);

Post::factory()->count(40)->create()->each(function($post) {
    $post->category()->associate(
        PostCategory::all()->random(1)
    );
});

Venue::factory()->count(40)->create();
Organizer::factory()->count(40)->create();


Teacher::factory()->count(40)->create()->each(function($teacher) {
    $teacher
        ->addMediaFromUrl('https://picsum.photos/300/200')
        ->toMediaCollection('profile_picture');
});


Event::factory()
    ->count(5000)
    ->state(new Sequence(
        ['repeat_type' => '1'],
    //['repeat_type' => '2'],
    //['repeat_type' => '3'],
    //['repeat_type' => '4'],
    ))
    ->create()->each(function($event) {
        $event->venue()->associate(
            Venue::all()->random(1)
        );
        $event->organizers()->sync(
            Organizer::all()->random()
        );
        $event->teachers()->sync(
            Teacher::all()->random(rand(1,4))
        );

        switch($event->repeat_type){
            case 1:
                EventRepetition::factory()->create([
                    'event_id' => $event->id,
                ]);
                break;
        }
    });


    Statistic::factory()->count(30)->create();
```
