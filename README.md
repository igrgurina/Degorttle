Degorttle
=========

Degordian battle - Degorttle

The basic version with just basic foot soldiers works fine, but the version with not just soldiers, but tanks, airplanes, helicopters, navy ships, as well as geo points and battle types (open land, sea, mountain, forest) is still buggy at times.

I don't say it doesn't work, it just sometimes breaks the engine due to overload of variables and possibilites - that breaking manifests itself with engine (sometimes) not declaring the winner.

Because of limited time I have (and because this is not going to be used in production), I'm going to leave it this way for now. In the future, if the need arises, I might fix it -> I know how to do that, but it'd take a lot of time.

If anyone is interested, here's how to fix it:
* play with numbers in Includes/Soldier.php, specifically $damage, $affected and $health for every type of soldier

You might just get the right combo to make it (always, not just sometimes) work.

p.s. sometimes === 7 in 10 tries
