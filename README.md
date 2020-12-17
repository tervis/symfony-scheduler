# Symfony Scheduler (DRAFT)

Designed to run only one command with cron at every minute

Command is protected by `Symfony\Component\Console\Command\LockableTrait` so only one instance can run at time.

```
# install with composer
composer require symfony/lock
```

Cron entry

```
# cron entry
* * * * * /usr/bin/php /path/to/current/bin/console scheduler:run > /dev/null
```

Command will execute tasks listed in Schedule-table by queueName and scheduledAt <= now


All Task tagged with app.schedule_task will get listed in SchedulerService
```yaml
services:
    _instanceof:
        # services whose classes are instances of TaskInterface will be tagged automatically
        App\Scheduler\TaskInterface:
        tags: ['app.scheduled_task']

    # collection of tagged tasks
    App\Scheduler\ScheduleManager:
        arguments:
          - !tagged_iterator 'app.scheduled_task'
```
## Schedule Entity

Scheduled tasks to run at scheduled time

| Field | type | desc |
|----|----|----|
| id | integer | |
| task_name | string | Task name as Task class short name |
| queue_name | string | Queue name |
| scheduled_at | datetime | time to task will run |
| executed_at | datetime, nullable | task executed time |
| description | string | Short description what will happen |
| context | json, nullable | extra data |

## Tasks

All Tasks should implement TaskInterface

Example:

```php

use App\Scheduler\TaskInterface;

class ExampleTask implements TaskInterface
{

    public function getClassName(): string
    {
        //Returns this class short name ie. SampleTask
        return (new \ReflectionClass($this))->getShortName();
    }

    public function getClass(): TaskInterface
    {
        return $this; //Returns the task class itself
    }

    public function getDescription(): string
    {
        return 'Task description ie. what task will do';
    }

    public function run()
    {
        // anything witch is needed to run for task
    }

}
```

## TaskDto

Schedule-entity data transfer object

Validates schedule data

## ScheduleFactory

Builds new Schedule from TaskDto

## ScheduleManager

Handles all Schedule actions 

methods:

- scheduleTask(TaskDto $taskDto)
  - Schedule a new runnable task
- removeTaskFromSchedule(Schedule $schedule)
  - Removes task from schedule
- getSchedule(?string $queueName = null)
  - Finds scheduled tasks from repository by queueName and <= now
- getAvailableTasks()
  - Returns available tasks as array
- setTaskExecutedAt(Schedule $schedule)
  - Sets task execution time to Schedule object

