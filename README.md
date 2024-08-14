# Description

The [documentation](https://symfony.com/doc/current/scheduler.html#exploring-alternatives-for-crafting-your-recurring-messages) says that a `RecurringMessage` can be built by adding `AsPeriodicTask` or `AsCronTask` into a command or service. 
When one of the attributes is added to a command with `aliases`, the application fails to trigger the command because it can't find the command. 

# Reproduce 
To reproduce this, run `composer install` to install the requirements.

This reproducer has to commands triggered by two different scheduler:

```
Which transports/receivers do you want to consume?                                                                     
                                                                                                                        

Choose which receivers you want to consume messages from in order of priority.
Hint: to consume from multiple, use a list of their names, e.g. scheduler_failure, scheduler_success

 Select receivers to consume: [scheduler_failure]:
  [0] scheduler_failure
  [1] scheduler_success
```

By running `$ bin/console messenger:consume scheduler_success`  a new line is written in the log every second.
```
app.INFO: This is foo [] []
```

The same behaviour is expected by running `$ bin/console messenger:consume scheduler_failure` but the following exception is thrown: 

```
messenger.CRITICAL: Error thrown while handling message Symfony\Component\Console\Messenger\RunCommandMessage. Removing from transport after 0 retries. Error: "Handling "Symfony\Component\Console\Messenger\RunCommandMessage" failed: There are no commands defined in the "this:is:bar|is" namespace.  Did you mean this?     this:is" {"class":"Symfony\\Component\\Console\\Messenger\\RunCommandMessage","message_id":null,"retryCount":0,"error":"Handling \"Symfony\\Component\\Console\\Messenger\\RunCommandMessage\" failed: There are no commands defined in the \"this:is:bar|is\" namespace.
```
