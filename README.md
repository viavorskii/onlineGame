# Online game
=============

## Installation

This is an api for an online game. It's implemented with symfony (PHP 7) and mysql.
I like using ApiDocBundle and you can have a look at /api/doc to play with it.
I also like using migration bundle and it means that you should set your database up with the command:

`./bin/console doctrine:migrations:migrate
`

I prepared the migration that will create a few "monsters" you can fight with.

## Designing process

I have to admit that I have never played online games and have never been a fan of computer games in general.
As you can imagine I have my own view on how the game should work.

If I understood everything correctly, we want to build the game where the character(you) should be able to explore the magic world and sometimes should meet somebody he can fight with.

In my opinion exploring means going. It means that the user will make step by step.
We create a ExploreController that has an action "step". The logic of the step will be found in the ExploreService.

Here I want to introduce you "Event". Everything that happens with a user is an event.
The character can find a magic box or something else that will help him to improve his experience.
The character also can stumble.
Events happen randomly. Such events like magic_box or stumble are very simple. The only thing that they can do is to change the user account.
To make it more structural I decided to present a Patch class which describes the changes.

According to the requirements the character should be able to fight. Then we define 2 interfaces:
1. EventFightInterface
2. EventInterface
And abstract classes for both that are encapsulating some common logic.

The events by itself are implementing everything that happens with the user. They are like independent scopes that describes the logic.
As I mentioned we have EventFightInterface that has a process method. FightEvent class describe a logic of the fight in general. The specific logic should be implemented in the certain service like HardFightService or SimpleFightService.
I created 2 of them to show how I can scale the app in the future.

If a user meet somebody he has to make a decition (fight/skip).
Actions and the whole logic is a logic of this particular fight type that described in the specific fight service.

To let user make a decision I prepared another api endpoint: api/secure/fight with action parameter.

Everything that happens and produce a change of user characteristics is logged to event table. It's like a game history.
So, you don't have to save your game, it's saved automatically.

As asked you can create a user and get user data using the password(auth) or secret key.
All of secure api endpoints require secret key of a user that was generated when the user was created.

I tried to explain everything clearly but if you have any questions or I forgot to describe something contact me please.

## Testing

I provided several unit tests that you can find in test directory.

## Things that need to be improved

I know that the design is not ideal and I have several things that I don't like:

1. Monster and User are implementing the CharacterInterface. I didn’t create a Model for the Character. I think it makes sense to do as long as the Entity is just database map object and can’t have any logic.
2. I didn’t implement the logic of dying so in the app you can have the life that is less then 0. But it’s quite easy to just check this condition and don’t let a user go further in the explore service. The question then how to earn the life to continue playing. :)