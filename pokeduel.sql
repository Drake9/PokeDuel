-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 14 Gru 2018, 14:48
-- Wersja serwera: 10.1.34-MariaDB
-- Wersja PHP: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `pokeduel`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `attackdex`
--

CREATE TABLE `attackdex` (
  `id` int(11) NOT NULL,
  `attackname` text CHARACTER SET utf8,
  `type` text CHARACTER SET utf8,
  `category` text CHARACTER SET utf8,
  `power` int(11) DEFAULT NULL,
  `cost` int(11) DEFAULT NULL,
  `keywords` text CHARACTER SET utf8,
  `description` text CHARACTER SET utf8,
  `signature` text CHARACTER SET utf8
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `attackdex`
--

INSERT INTO `attackdex` (`id`, `attackname`, `type`, `category`, `power`, `cost`, `keywords`, `description`, `signature`) VALUES
(1, 'Scratch', 'normal', 'PA', 1, 1, 'contact', 'User scratches its foe with sharp claws.', NULL),
(2, 'Tackle', 'normal', 'PA', 3, 2, 'contact', 'User attacks foe with its full body.', NULL),
(3, 'Double Edge', 'normal', 'PA', 5, 2, 'contact recoil', 'A risky, full body attack, that causes RECOIL damage.', NULL),
(4, 'Quick Attack', 'normal', 'PA', 1, 2, 'contact quick', 'A QUICK attack.', NULL),
(5, 'Wrap', 'normal', 'PA', 1, 3, 'contact status:opp:trapped', 'User TRAPS its foe with limbs or long body.', NULL),
(6, 'Swift', 'normal', 'SA', 2, 2, 'area', 'An attack that never misses.', NULL),
(7, 'Dodge', 'normal', 'S', NULL, 2, 'react dodge', 'User DODGES the enemy\'s attack. User must be at least as fast as its enemy.', NULL),
(8, 'Rapid Spin', 'normal', 'PA', 1, 2, 'contact unique RapidSpin', 'Attack that gets user out of the trap.', NULL),
(9, 'Hyper Beam', 'normal', 'SA', 6, 3, 'status:self:exhausted', 'Attacks with a powerful beam. Must rest on the next turn.', NULL),
(10, 'Harden (Defense Curl)', 'normal', 'S', NULL, 1, 'stats:self:defence:specdef:1', 'Raises defence and special defence.', NULL),
(11, 'Ember', 'fire', 'SA', 1, 1, 'chance status:opp:burned', 'Burns the enemy with a small flame.', NULL),
(12, 'Flamethrower', 'fire', 'SA', 3, 2, 'chance status:opp:burned', 'Throws flames at the enemy', NULL),
(13, 'Fire Blast', 'fire', 'SA', 5, 3, 'chance status:opp:burned', 'Blast the enemy with huge, incredibly hot flame.', NULL),
(14, 'Fire Fang', 'fire', 'PA', 3, 2, 'chance status:opp:burned contact', 'Bites the enemy with fangs burned with flames.', NULL),
(15, 'Fire Spin', 'fire', 'SA', 1, 3, 'status:opp:trapped', 'TRAPS the enemy in flames.', NULL),
(16, 'Inferno', 'fire', 'SA', 3, 3, 'status:opp:burned', 'Engulfs the target in intense fire, BURNING it.', NULL),
(17, 'Flame Charge', 'fire', 'PA', 2, 2, 'contact stats:self:speed:1', 'The user cloaks itself with flame and attacks, gaining speed. ', NULL),
(18, 'Heat Crash', 'fire', 'PA', 0, 2, 'power:massRatio contact', 'The user slams target with its flame-covered body. Power depends on the weight ratio.', NULL),
(19, 'Overheat', 'fire', 'SA', 5, 2, 'stats:self:specatt:-2', 'Full power attack that lowers special attack of its user.', NULL),
(20, 'Blast Burn', 'fire', 'SA', 6, 3, 'status:self:exhausted', 'Razes foe by a fiery explosion, but exhausts user, leaving it immobile next turn', NULL),
(21, 'Water Gun', 'water', 'SA', 1, 1, 'NULL', 'Squirts water to attack.', NULL),
(22, 'Bubble Beam', 'water', 'SA', 3, 2, 'chance stats:opp:speed:-1', 'Forcefully throws bubbles that may lower foe\'s speed.', NULL),
(23, 'Hydro Pump', 'water', 'SA', 5, 3, 'NULL', 'Blasts water at high power to strike the foe.', NULL),
(24, 'Aqua Tail', 'water', 'PA', 3, 2, 'contact', 'Slaps the target with wet tail. Or something.', NULL),
(25, 'Whirpool', 'water', 'SA', 1, 3, 'status:opp:trapped', 'TRAPS the foe in a whirpool.', NULL),
(26, 'Dive', 'water', 'PA', 3, 2, 'loaded status:self:hidden contact', '1st turn: dives, becoming invulnerable; 2nd turn: attacks', NULL),
(27, 'Aqua Jet', 'water', 'PA', 1, 2, 'quick contact', 'User lunges at the target at high speed. QUICK', NULL),
(28, 'Crabhammer', 'water', 'PA', 3, 2, 'chance crit', 'Hammers with a pincer. CRIT CHANCE', NULL),
(29, 'Surf', 'water', 'SA', 3, 2, 'area', 'Creates a huge wave, then crashes it down on the foe. AREA', NULL),
(30, 'Hydro Cannon', 'water', 'SA', 6, 3, 'status:self:exhausted', 'Attacks foe with an incredibly huge blast of water, but exhausts user.', NULL),
(31, 'Thunder Shock', 'electric', 'SA', 1, 1, 'chance status:opp:paralyzed', 'A jolt of electricity is hurled at the foe', NULL),
(32, 'Thunderbolt', 'electric', 'SA', 3, 2, 'chance status:opp:paralyzed', 'A strong electric blast is loosed at the foe.', NULL),
(33, 'Thunder', 'electric', 'SA', 5, 3, 'chance status:opp:paralyzed', 'A brutal lightning attack.', NULL),
(34, 'Thunder Punch', 'electric', 'PA', 3, 2, 'chance status:opp:paralyzed contact', 'An electric punch.', NULL),
(35, 'Thunder Weave', 'electric', 'S', NULL, 1, 'status:opp:paralyzed', 'Attackes uses electricity to PARALYZE the target.', NULL),
(36, 'Zap Cannon', 'electric', 'SA', 6, 4, 'status:opp:paralyzed', 'An electric blast is fired like a cannon to inflict damage and PARALYZE.', NULL),
(37, 'Charge Beam', 'electric', 'SA', 2, 2, 'stats:self:specatt:1', 'The user attacks with an electric charge and boosts its special attack with remaining electricity.', NULL),
(38, 'Wild Charge', 'electric', 'PA', 3, 1, 'recoil contact', 'The user shrouds itself in electricity and recklessly smashes into its target. RECOIL', NULL),
(39, 'Discharge', 'electric', 'SA', 4, 2, 'stats:self:specatt:-1 area', 'A flare of electricity is loosed to strike the AREA around the user.', NULL),
(40, 'Charge', 'electric', 'S', NULL, 1, 'stats:self:specatt,specdef:1', 'The user charges its power, raising special stats.', NULL),
(41, 'Vine Whip', 'grass', 'PA', 1, 1, 'NULL', 'Whips the foe with slender vines.', NULL),
(42, 'Leaf Blade', 'grass', 'PA', 3, 2, 'chance crit', 'Slashes the foe with sharp leaves. CRIT CHANCE', NULL),
(43, 'Solar Beam', 'grass', 'SA', 5, 2, 'loaded', 'Absorbs light in one turn and attacks in next. LOADED', NULL),
(44, 'Mega Drain', 'grass', 'SA', 2, 2, 'drain:1', 'A nutritient-draining attack. DRAIN:1', NULL),
(45, 'Leech Seed', 'grass', 'S', NULL, 1, 'unique LeechSeed', 'Plants a seen on the foe to steal HP every turn', NULL),
(46, 'Sleep Powder', 'grass', 'S', NULL, 1, 'status:opp:sleeping', 'Scatters a powder that causes foe to SLEEP.', NULL),
(47, 'Giga Drain', 'grass', 'SA', 3, 3, 'drain:2', 'A harsh attack that drains HP from the foe. DRAIN:2', NULL),
(48, 'Stun Spore', 'grass', 'S', NULL, 1, 'status:opp:paralyzed', 'Scatters PARALYZING dust.', NULL),
(49, 'Leaf Storm', 'grass', 'SA', 5, 2, 'stats:self:specatt:-2', 'A storm of sharp leaves is whipped up. Lowers special attack of user.', NULL),
(50, 'Frenzy Plant', 'grass', 'SA', 6, 3, 'status:self:exhausted', 'No idea. Powerful, but exhausting.', NULL),
(51, 'Powder Snow', 'ice', 'SA', 1, 1, 'chance:freeze', 'Chilling gust of powdery snow.', NULL),
(52, 'Aurora Beam', 'ice', 'SA', 3, 2, 'chance stats:opp:attack:-1', 'Fires a rainbow-colored beam that may lower foe\'s attack.', NULL),
(53, 'Blizzard', 'ice', 'SA', 5, 3, 'area chance:freeze', 'The AREA is blasted with a blizzard.', NULL),
(54, 'Ice Fang', 'ice', 'PA', 3, 2, 'chance:freeze contact', 'The user bites with cold-infused fangs.', NULL),
(55, 'Hail', 'ice', 'S', NULL, 1, 'weather:hailstorm', 'Summons a hailstorm.', NULL),
(56, 'Sheer Cold', 'ice', 'SA', NULL, 3, 'unique attempt:KO', 'The foe is attacked with ultimate cold. RPS', 'Poliwrath'),
(57, 'Ice Shard', 'ice', 'PA', 1, 2, 'quick', 'The user hurls chunks of ice at the target. QUICK', NULL),
(58, 'Icy Wind', 'ice', 'SA', 2, 2, 'stats:opp:speed:-1', 'Foe is attacked with a chilling wind which lowers its speed.', NULL),
(59, 'Freeze-Dry', 'ice', 'SA', 3, 2, 'chance:freeze unique bonus:water', 'The user rapidly cools the target. Effective against water.', NULL),
(60, 'Freeze Shock', 'ice', 'PA', 6, 2, 'loaded chance status:opp:paralyzed', 'A two-turn attack with electrically-charged ice. LOADED', NULL),
(61, 'Rock Smash', 'fighting', 'PA', 1, 1, 'chance stats:opp:defence:-1', 'A rock-crushing attack that may lower foe\'s defence.', NULL),
(62, 'Karate Chop', 'fighting', 'PA', 3, 2, 'chance crit contact', 'The foe is attacked with a sharp chop. CRIT CHANCE', NULL),
(63, 'Cross Chop', 'fighting', 'PA', 5, 3, 'chance crit contact', 'A double-chopping attack with a chance of critical hit. CRIT CHANCE', NULL),
(64, 'Focus Blast', 'fighting', 'SA', 5, 3, 'chance stats:opp:specdef:-1', 'No idea. Has a chance of lowering foe\'s special defence.', NULL),
(65, 'Low Sweep', 'fighting', 'S', NULL, 1, 'stats:opp:speed:-2 contact', 'The user attacks opponent\'s legs to harshly lower its speed.', NULL),
(66, 'Superpower', 'fighting', 'PA', 5, 2, 'stats:self:attack,defence:-1 contact', 'User attacks with great power, lowering its attack and defence.', 'Nidoqueen'),
(67, 'Mach Punch', 'fighting', 'PA', 1, 2, 'quick contact', 'The user throws a punch at blinding speed. QUICK', NULL),
(68, 'Bulk Up', 'fighting', 'S', NULL, 1, 'stats:self:attack,defence:1', 'The user tenses its muscles, raising attack and defence.', NULL),
(69, 'Counter', 'fighting', 'PA', 0, 3, 'react counterattack:PA', 'INTERCEPTS any physical hit.', NULL),
(70, 'Seismic Toss', 'fighting', 'PA', 0, 2, 'power:oppMass', 'A gravity-fed throw. Power depends on foe\'s weight.', NULL),
(71, 'Poison Sting', 'poison', 'PA', 1, 1, 'chance status:opp:poisoned contact', 'The foe is stabbed with a toxic barb.', NULL),
(72, 'Poison Jab', 'poison', 'PA', 3, 2, 'chance status:opp:poisoned contact', 'A stronger stab with chance for poisoning.', NULL),
(73, 'Gunk Shot', 'poison', 'PA', 5, 3, 'chance status:opp:poisoned', 'User throws rubbish, just as a retard on forum.', NULL),
(74, 'Sludge Bomb', 'poison', 'SA', 3, 2, 'chance status:opp:poisoned', 'Sludge is hurled to inflict damage.', NULL),
(75, 'Poison Powder (Poison Gas)', 'poison', 'S', NULL, 1, 'status:opp:poisoned', 'The foe is POISONED with a toxic gas or a cloud of powder.', NULL),
(76, 'Acid Spray', 'poison', 'SA', 2, 2, 'stats:opp:specdef:-2', 'The user spits fluid that works to melt the target, harshly reducing special defence.', NULL),
(77, 'Poison Fang', 'poison', 'PA', 2, 2, 'status:opp:poisoned contact', 'The foe is bitten with toxic fangs and becomes POISONED.', NULL),
(78, 'Acid Armor', 'poison', 'S', NULL, 1, 'stats:self:defence:2', 'Sharply raises defence.', NULL),
(79, 'Smog', 'poison', 'SA', 1, 1, 'chance:status:opp:poisoned', 'An exhaust-gas attack that may also poison.', NULL),
(80, 'Venoshock', 'poison', 'SA', 2, 2, 'bonus:poisoned', 'The power of this toxic liquid is doubled against poisoned targets.', NULL),
(81, 'Mud-Slap', 'ground', 'SA', 1, 1, NULL, 'The user hurl mud.', NULL),
(82, 'Drill Run', 'ground', 'PA', 3, 2, 'chance crit contact', 'The user crashes into its target while rotating its body. CRIT CHANCE', NULL),
(83, 'Earthquake', 'ground', 'PA', 5, 3, 'area', 'The user setf off an earthquake. AREA', NULL),
(84, 'Mud Bomb', 'ground', 'SA', 3, 2, NULL, 'The user launches a hard-packed mud ball.', NULL),
(85, 'Sand Tomb', 'ground', 'PA', 1, 3, 'status:opp:trapped', 'TRAPS the foe in a sandstorm.', NULL),
(86, 'Fissure', 'ground', 'PA', NULL, 3, 'unique attempt:KO', 'The user opens up a fissure in the ground beneath its foe. RPS', NULL),
(87, 'Bulldoze', 'ground', 'PA', 2, 2, 'area stats:opp:speed:-1', 'The user stomps, damaging the ground to lower foe\'s speed. AREA', NULL),
(88, 'Earth Power', 'ground', 'SA', 4, 3, 'stats:opp:specdef:-1', 'The ground under the target erupts with power, lowering its special defence.', NULL),
(89, 'Dig', 'ground', 'PA', 3, 2, 'loaded status:self:hidden contact', '1st turn: burrow; 2nd turn: attack', NULL),
(90, 'Magnitude', 'ground', 'PA', 0, 2, 'unique power:random', 'A ground-shaking attack hitting with random power.', NULL),
(91, 'Peck', 'flying', 'PA', 1, 1, 'contact', 'Jabs the foe with a beak, etc.', NULL),
(92, 'Wing Attack', 'flying', 'PA', 3, 2, 'contact', 'Strikes the foe with wings spread wide.', NULL),
(93, 'Hurricane', 'flying', 'SA', 5, 3, 'area', 'Attacks the foe with a fierce wind. AREA', NULL),
(94, 'Air Slash', 'flying', 'SA', 3, 2, 'chance status:opp:flinched', 'Slices the target with a blade of air.', NULL),
(95, 'Sky Drop', 'flying', 'PA', 0, 2, 'contact power:mass', 'The user takes the target into the sky and drops it. Power depends on foe\'s weight.', NULL),
(96, 'Fly', 'flying', 'PA', 3, 2, 'loaded status:self:hidden contact', '1st turn: fly up high; 2nd turn: attack', NULL),
(97, 'Defog', 'flying', 'S', NULL, 1, 'weather:clear skies', 'Whips up a turbulent whirlwind, clears the weather.', NULL),
(98, 'Brave Bird', 'flying', 'PA', 5, 2, 'recoil contact', 'The user tucks in its wings and charges from a low altitude. RECOIL', NULL),
(99, 'Aerial Ace', 'flying', 'PA', 2, 2, 'contact quick', 'The user confounds the target with speed, avoiding disturbance. QUICK', NULL),
(100, 'Sky Attack', 'flying', 'PA', 6, 2, 'loaded contact', 'Searches out weak spots, then strikes the next turn. LOADED', NULL),
(101, 'Confusion', 'psychic', 'SA', 1, 1, 'chance status:opp:confused', 'A psychic attack that may cause confusion.', 'Butterfree'),
(102, 'Psybeam', 'psychic', 'SA', 3, 2, 'chance status:opp:confused', 'A peculiar ray that may confuse the foe.', NULL),
(103, 'Psychic', 'psychic', 'SA', 5, 3, 'chance stats:opp:specdef:-1', 'A powerful psychic attack that may lower special defense.', NULL),
(104, 'Psycho Cut', 'psychic', 'PA', 3, 2, 'chance crit', 'The user tears at the foe with blades formed by psychic power. CRIT CHANCE', NULL),
(105, 'Hypnosis', 'psychic', 'S', NULL, 1, 'status:opp:sleeping', 'A hypnotizing move that induces SLEEP.', NULL),
(106, 'Telekinesis', 'psychic', 'S', NULL, 1, 'status:opp:paralyzed', 'Uses psychic power to PARALYZE the foe.', NULL),
(107, 'Teleport', 'psychic', 'S', NULL, 2, 'unique react Teleport dodge', 'User teleports itself to DODGE the attack. Works against faster foes.', NULL),
(108, 'Barrier', 'psychic', 'S', NULL, 1, 'stats:self:defence:2', 'Sharply raises user\'s defence.', NULL),
(109, 'Mirror Coat', 'psychic', 'SA', 0, 3, 'react counterattack:SA', 'INTERCEPTS special attack.', NULL),
(110, 'Psycho Boost', 'psychic', 'SA', 6, 3, 'stats:self:specatt:-2', 'Performs a full-power strike, but sharply lowers special attack.', NULL),
(111, 'Twineedle', 'bug', 'PA', 1, 1, 'chance status:opp:poisoned contact', 'Jabs the foe using poisoned stingers.', NULL),
(112, 'X-Scissor', 'bug', 'PA', 3, 2, 'contact', 'Slashes from both sides with claws or scythes.', NULL),
(113, 'Megahorn', 'bug', 'PA', 5, 3, 'contact', 'A brutal ramming attack with impressive horn.', 'Nidoking'),
(114, 'Signal Beam', 'bug', 'SA', 3, 2, 'chance status:opp:confused', 'A sinister beam of light, which may cause confusion.', NULL),
(115, 'String Shot', 'bug', 'S', NULL, 1, 'stats:opp:speed:-2', 'Binds the foe with silk to harshly reduce its speed.', NULL),
(116, 'Fury Cutter', 'bug', 'PA', 1, 1, 'reuse contact rising', 'Slash with scythes or claws. Power increases if it is used again next turn.', NULL),
(117, 'Leech Life', 'bug', 'PA', 2, 2, 'drain:1 contact', 'A blood-draining attack. DRAIN:1', NULL),
(118, 'Quiver Dance', 'bug', 'S', NULL, 1, 'stats:self:specatt,specdef,speed:1', 'The user lightly performs a beautiful, mystic dance, raising specials and speed.', NULL),
(119, 'Pin Missile', 'bug', 'PA', 0, 3, 'unique times:3', 'Sharp pins are fired to strike three times.', NULL),
(120, 'Fell Stinger', 'bug', 'PA', 2, 2, 'contact unique FellStinger', 'Drastically raises user\'s Attack if target is KO\'d.', NULL),
(121, 'Rock Throw', 'rock', 'PA', 1, 1, NULL, 'Throws small rocks to strike the foe.', NULL),
(122, 'Rock Blast', 'rock', 'PA', 3, 2, NULL, 'Hurls boulders at the foe.', NULL),
(123, 'Stone Edge', 'rock', 'PA', 5, 3, 'chance crit', 'The user stabs the target with sharpened stones from below. CRIT CHANCE', NULL),
(124, 'Power Gem', 'rock', 'SA', 3, 2, NULL, 'Ray of light that sparkles like gemstones.', NULL),
(125, 'Sandstorm', 'rock', 'S', NULL, 1, 'weather:sandstorm', 'Creates a sandstorm, which reduce damage from special attacks.', NULL),
(126, 'Rollout', 'rock', 'PA', 1, 1, 'reuse contact rising', 'Rolls into the foe. Power increases if it is used next turn.', NULL),
(127, 'Ancient Power', 'rock', 'SA', 3, 3, 'chance stats:self:attack,defence,specatt,specdef,speed:1', 'The user attacks with a prehistoric power. May boost all stats.', NULL),
(128, 'Head Smash', 'rock', 'PA', 6, 3, 'recoil contact', 'A hazardous, full-power headbutt. RECOIL', NULL),
(129, 'Stone Ram', 'rock', 'PA', 0, 2, 'power:massRatio contact', 'Rams the foe with its mass. Power depends on weight ratio.', NULL),
(130, 'Rock Wrecker', 'rock', 'PA', 6, 3, 'status:self:exhausted', 'The user launches a huge boulder. It must rest on the next turn, however.', NULL),
(131, 'Lick', 'ghost', 'PA', 1, 1, 'chance:paralyze contact', 'Licks with a long tongue. May cause paralysis.', NULL),
(132, 'Shadow Ball', 'ghost', 'SA', 3, 2, 'chance stats:opp:specdef:-1', 'Hurls a shadowy blob, which may lower special defence.', NULL),
(133, 'Night Shade', 'ghost', 'SA', 5, 3, NULL, 'The user makes the target see a frightening mirage.', NULL),
(134, 'Shadow Claw', 'ghost', 'PA', 3, 2, 'chance crit contact', 'Slashes with a sharp claw made from shadows. CRIT CHANCE', NULL),
(135, 'Confuse Ray', 'ghost', 'S', NULL, 1, 'status:opp:confused', 'A sinister ray that triggers CONFUSION.', NULL),
(136, 'Phantom Force', 'ghost', 'PA', 3, 2, 'loaded status:self:hidden contact', 'The user vanishes, then strikes the target on the next turn.', NULL),
(137, 'Shadow Sneak', 'ghost', 'PA', 1, 2, 'quick contact', 'The user extends its shadow and attacks from behind. QUICK', NULL),
(138, 'Spite', 'ghost', 'SA', 2, 2, 'unique Spite', 'Spitefully interrupts loading attacks.', NULL),
(139, 'Nightmare', 'ghost', 'SA', 3, 2, 'unique Nightmare', 'Has a chance not to wake the target up.', NULL),
(140, 'Hex', 'ghost', 'SA', 2, 2, 'unique bonus:status', 'Power doubles against targets affected by special conditions.', NULL),
(141, 'Twister', 'dragon', 'SA', 1, 1, 'chance status:opp:flinched', 'Whips up a tornado to attack.', NULL),
(142, 'Dragon Breath', 'dragon', 'SA', 3, 2, 'chance status:opp:paralyzed', 'Strikes the foe with an incredible blast of breath, which may cause paralysis.', NULL),
(143, 'Dragon Rush', 'dragon', 'PA', 5, 3, 'chance status:opp:flinched contact', 'The user tackles the foe while exhibiting overwhelming menace.', NULL),
(144, 'Dragon Claw', 'dragon', 'PA', 3, 2, 'contact', 'The user slashes the target with huge, sharp claws.', NULL),
(145, 'Dragon Tail', 'dragon', 'PA', 1, 1, NULL, 'The user knocks away the target with its tail.', NULL),
(146, 'Roar of Time', 'dragon', 'SA', 6, 3, 'status:self:exhausted', 'User must recharge next turn.', NULL),
(147, 'Dragon Rage', 'dragon', 'SA', 3, 2, 'unique power:3', 'The foe loses 3HP.', NULL),
(148, 'Dragon Dance', 'dragon', 'S', NULL, 1, 'stats:self:attack,speed:1', 'A mystical dance that ups attack and speed.', NULL),
(149, 'Draco Meteor', 'dragon', 'SA', 5, 2, 'stats:self:specatt:-2', 'Summons a comet from the sky. Sharply reduces special attack.', NULL),
(150, 'Outrage', 'dragon', 'PA', 3, 1, 'contact reuse status:self:confused', 'Can be used up to three times but causes confusion.', 'Gyarados'),
(151, 'Bite', 'dark', 'PA', 1, 1, 'chance status:opp:flinched contact', 'Bites with vicious fangs.', NULL),
(152, 'Crunch', 'dark', 'PA', 3, 2, 'chance stats:opp:defence:-1 contact', 'The foe is crunched with sharp fangs.', NULL),
(153, 'Foul Play', 'dark', 'PA', 5, 3, 'unique contact', 'Uses the attack stat of the foe.', NULL),
(154, 'Dark Pulse', 'dark', 'SA', 3, 2, 'chance status:opp:flinched', 'Releases a horrible aura imbued with dark thoughts.', NULL),
(155, 'Pursuit', 'dark', 'PA', 2, 1, 'react:switch contact', 'User attacks when the foe is switching out.', NULL),
(156, 'Payback', 'dark', 'PA', 2, 2, 'react:quick contact', '___Needs redesign.', NULL),
(157, 'Sucker Punch', 'dark', 'PA', 2, 2, 'react:attack contact', 'An extremely quick attack.', NULL),
(158, 'Torment', 'dark', 'S', NULL, 1, 'unique contact', 'The tormented foe loses 2 energy.', NULL),
(159, NULL, 'dark', NULL, NULL, NULL, NULL, NULL, NULL),
(160, 'Punishment', 'dark', 'PA', 2, 2, 'bonus:buff contact', 'Power grows by one for each buff on the foe.', NULL),
(161, 'Metal Claw', 'steel', 'PA', 1, 1, 'chance stats:self:attack:1 contact', 'The foe is attacked with steel claws. May increase attack.', NULL),
(162, 'Steel Wing', 'steel', 'PA', 3, 2, 'chance stats:self:defence:1 contact', 'Strikes the foe with hard wings spread wide. May increase defence.', NULL),
(163, 'Iron Tail', 'steel', 'PA', 5, 3, 'chance stats:opp:defence:-1 contact', 'Slams the target with a steel-hard tail. May lower foe\'s defence.', NULL),
(164, 'Flash Cannon', 'steel', 'SA', 3, 2, 'chance stats:opp:specdef:-1', 'User gathers light energy and releases it at once. May lower foe\'s special defence.', NULL),
(165, 'Metal Sound', 'steel', 'S', NULL, 1, 'stats:opp:specdef:-2', 'A horrible screech that harshly reduces special defense.', NULL),
(166, 'Metal Burst', 'steel', 'SA', 5, 3, NULL, 'The foe is attacked with a huge burst.', NULL),
(167, 'Bullet Punch', 'steel', 'PA', 1, 2, 'quick contact', 'Strikes with a tough punch as fast as a bullet. QUICK', NULL),
(168, 'Iron Defense', 'steel', 'S', NULL, 1, 'stats:self:defence:2', 'User hardens surface of its body, harshly increasing defence.', NULL),
(169, 'Gyro Ball', 'steel', 'PA', 0, 2, 'power:slow contact', 'Tackles the foe with a high-speed spin. Power depends on speed difference.', NULL),
(170, 'Heavy Slam', 'steel', 'PA', 0, 2, 'power:massRatio contact', 'Slams into the target with heavy body. Power depends on weight ratio.', NULL),
(171, 'Fairy Wind', 'fairy', 'SA', 1, 1, NULL, 'Strikes the target with a fairy wind.', NULL),
(172, 'Dazzling Gleam', 'fairy', 'SA', 3, 2, 'area', 'A powerful flash. AREA', NULL),
(173, 'Fleur Cannon', 'fairy', 'SA', 5, 2, 'stats:self:specatt:-2', 'The user unleashes a strong beam, harshly lowering its special attack.', NULL),
(174, 'Play Rough', 'fairy', 'PA', 3, 2, 'chance stats:opp:attack:-1 contact', 'The user plays rough with the target and attacks it. Has a chance of lowering foe\'s attack.', NULL),
(175, 'Sweet Kiss', 'fairy', 'S', NULL, 1, 'status:opp:confused contact', 'CONFUSES the target.', NULL),
(176, 'Draining Kiss', 'fairy', 'SA', 2, 2, 'drain:1 contact', 'Steals the target energy with a kiss. DRAIN:1', NULL),
(177, 'Baby-Doll Eyes', 'fairy', 'S', NULL, 1, 'quick stats:opp:attack:-1', 'Stares at the target with baby-doll eyes, lowering attack. QUICK', NULL),
(178, 'Moonlight', 'fairy', 'S', NULL, 2, 'unique heal:4', 'Heals the user (4 HP).', NULL),
(179, 'Charm', 'fairy', 'S', NULL, 1, 'stats:opp:attack:-2', 'Charms the foe to harshly reduce its attack.', NULL),
(180, 'Light of Ruin', 'fairy', 'SA', 6, 3, 'recoil', 'No idea. RECOIL damage.', NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `players`
--

CREATE TABLE `players` (
  `id` int(11) NOT NULL,
  `nick` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `password` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `email` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `since` date NOT NULL,
  `wins` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `players`
--

INSERT INTO `players` (`id`, `nick`, `password`, `email`, `since`, `wins`) VALUES
(1, 'Trox', '$2y$10$IEWtby.AKxkLwJAtvnW/COxo5fX.U11xArjtZi86OxElaYroHUxW2', 'cysorz@gmail.com', '2017-11-22', 0),
(3, 'Stefan', '$2y$10$tZpQnahoqdwHkDG6GXr47e9dhVt1RWOWushqK6JGPh6iWU9asecAq', 'stanisuaf@gmail.com', '2018-06-11', 4),
(4, 'FranekKimono', '$2y$10$576IpOW8aCl5Mtadu8.oEug67IcH35uBAjOvBHWnz1nKsnaSMkHEm', 'franio@gmail.com', '2018-10-12', 1),
(5, 'Marcepan', '$2y$10$DT7dpN41L86kx/wY6dBhCOcMyeOmxj.NPok31spQWTTI6lYnX7uBG', 'sweet@gmail.com', '2018-10-17', 1),
(6, 'Paradise', '$2y$10$hmOnetAbs.xgH2dOMZPFJ.gFB4h8qyLDBvkHgoFGFENViUFY5WO/i', 'eden@gmail.com', '2018-10-29', 0),
(7, 'BoltzmannBrain', '$2y$10$.h5lOGmHDN9Wdgz8cpH2qe4NhRDm9enepyzlpGm5BvHqQDpC.U4p.', 'brain@gmail.com', '2018-11-02', 1),
(8, 'TheTower', '$2y$10$soXy46iuoM/tSTgSacK6ouLd/8cWIHn2jplVpO8KZQD6nuQ6LKPn6', 'tower@gmail.com', '2018-11-06', 0),
(9, 'LawrenceIII', '$2y$10$YBsoGlPxV1IJeE2AC8c/seK/Q2QWiVk8CuIAfLMhwwFJy7aplTJh2', 'jerk@gmail.com', '2018-11-13', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pokedex`
--

CREATE TABLE `pokedex` (
  `number` int(11) NOT NULL,
  `name` text CHARACTER SET utf8,
  `typeprim` text CHARACTER SET utf8,
  `typesec` text CHARACTER SET utf8,
  `species` text CHARACTER SET utf8,
  `height` float DEFAULT NULL,
  `weight` float DEFAULT NULL,
  `abilities` text CHARACTER SET utf8,
  `hp` int(11) DEFAULT NULL,
  `attack` int(11) DEFAULT NULL,
  `defence` int(11) DEFAULT NULL,
  `specattack` int(11) DEFAULT NULL,
  `specdefence` int(11) DEFAULT NULL,
  `speed` int(11) DEFAULT NULL,
  `normal` int(11) DEFAULT NULL,
  `fire` int(11) DEFAULT NULL,
  `water` int(11) DEFAULT NULL,
  `electric` int(11) DEFAULT NULL,
  `grass` int(11) DEFAULT NULL,
  `ice` int(11) DEFAULT NULL,
  `fighting` int(11) DEFAULT NULL,
  `poison` int(11) DEFAULT NULL,
  `ground` int(11) DEFAULT NULL,
  `flying` int(11) DEFAULT NULL,
  `psychic` int(11) DEFAULT NULL,
  `bug` int(11) DEFAULT NULL,
  `rock` int(11) DEFAULT NULL,
  `ghost` int(11) DEFAULT NULL,
  `dragon` int(11) DEFAULT NULL,
  `darkness` int(11) DEFAULT NULL,
  `steel` int(11) DEFAULT NULL,
  `fairy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `pokedex`
--

INSERT INTO `pokedex` (`number`, `name`, `typeprim`, `typesec`, `species`, `height`, `weight`, `abilities`, `hp`, `attack`, `defence`, `specattack`, `specdefence`, `speed`, `normal`, `fire`, `water`, `electric`, `grass`, `ice`, `fighting`, `poison`, `ground`, `flying`, `psychic`, `bug`, `rock`, `ghost`, `dragon`, `darkness`, `steel`, `fairy`) VALUES
(1, 'Bulbasaur', 'grass', 'poison', 'Seed Pokemon', 0.71, 6.9, 'Overgrow Chlorophyll', 2, 3, 2, 3, 3, 3, NULL, 1, -1, -1, -2, 1, -1, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, -1),
(2, 'Ivysaur', 'grass', 'poison', 'Seed Pokemon', 0.99, 13, 'Overgrow Chlorophyll', 3, 3, 3, 4, 3, 3, NULL, 1, -1, -1, -2, 1, -1, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, -1),
(3, 'Venusaur', 'grass', 'poison', 'Seed Pokemon', 2.01, 100, 'Overgrow Chlorophyll', 3, 4, 4, 5, 4, 4, NULL, 1, -1, -1, -2, 1, -1, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, -1),
(4, 'Charmander', 'fire', NULL, 'Lizard Pokemon', 0.61, 8.5, 'Blaze SolarPower', 2, 3, 2, 3, 2, 4, NULL, -1, 1, NULL, -1, -1, NULL, NULL, 1, NULL, NULL, -1, 1, NULL, NULL, NULL, -1, -1),
(5, 'Charmeleon', 'fire', NULL, 'Flame Pokemon', 1.09, 19, 'Blaze SolarPower', 3, 3, 3, 4, 3, 4, NULL, -1, 1, NULL, -1, -1, NULL, NULL, 1, NULL, NULL, -1, 1, NULL, NULL, NULL, -1, -1),
(6, 'Charizard', 'fire', 'flying', 'Flame Pokemon', 1.7, 90.5, 'Blaze SolarPower', 3, 4, 3, 5, 4, 5, NULL, -1, 1, 1, -2, NULL, -1, NULL, 0, NULL, NULL, -2, 2, NULL, NULL, NULL, -1, -1),
(7, 'Squirtle', 'water', NULL, 'Turtle Pokemon', 0.51, 9, 'Torrent RainDish', 2, 3, 3, 2, 3, 2, NULL, -1, -1, 1, 1, -1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, -1, NULL),
(8, 'Wartortle', 'water', NULL, 'Turtle Pokemon', 0.99, 22.5, 'Torrent RainDish', 3, 3, 4, 3, 3, 3, NULL, -1, -1, 1, 1, -1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, -1, NULL),
(9, 'Blastoise', 'water', NULL, 'Turtle Pokemon', 1.6, 85.5, 'Torrent RainDish', 3, 4, 4, 4, 4, 4, NULL, -1, -1, 1, 1, -1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, -1, NULL),
(10, 'Caterpie', 'bug', NULL, 'Worm Pokemon', 0.3, 2.9, 'ShieldDust RunAway', 2, 2, 2, 1, 1, 3, NULL, 1, NULL, NULL, -1, NULL, -1, NULL, -1, 1, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL),
(11, 'Metapod', 'bug', NULL, 'Cocoon Pokemon', 0.71, 9.9, 'ShedSkin', 2, 1, 3, 1, 1, 2, NULL, 1, NULL, NULL, -1, NULL, -1, NULL, -1, 1, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL),
(12, 'Butterfree', 'bug', 'flying', 'Butterfly Pokemon', 1.09, 32, 'CompoundEyes TintedLens', 3, 2, 2, 4, 3, 4, NULL, 1, NULL, 1, -2, 1, -2, NULL, 0, 1, NULL, -1, 2, NULL, NULL, NULL, NULL, NULL),
(13, 'Weedle', 'bug', 'poison', 'Hairy Bug Pokemon', 0.3, 3.2, 'ShieldDust RunAway', 2, 2, 2, 1, 1, 3, NULL, 1, NULL, NULL, -2, NULL, -2, -1, NULL, 1, 1, -1, 1, NULL, NULL, NULL, NULL, -1),
(14, 'Kakuna', 'bug', 'poison', 'Cocoon Pokemon', 0.61, 10, 'ShedSkin', 2, 1, 2, 1, 1, 2, NULL, 1, NULL, NULL, -2, NULL, -2, -1, NULL, 1, 1, -1, 1, NULL, NULL, NULL, NULL, -1),
(15, 'Beedrill', 'bug', 'poison', 'Poison Bee Pokemon', 0.99, 29.5, 'Swarm Sniper', 3, 5, 2, 2, 3, 4, NULL, 1, NULL, NULL, -2, NULL, -2, -1, NULL, 1, 1, -1, 1, NULL, NULL, NULL, NULL, -1),
(16, 'Pidgey', 'normal', 'flying', 'Bird Pokemon', 0.3, 1.8, 'KeenEye TangledFeet', 2, 2, 2, 2, 2, 3, NULL, NULL, NULL, 1, -1, 1, NULL, NULL, 0, NULL, NULL, -1, 1, 0, NULL, NULL, NULL, NULL),
(17, 'Pidgeotto', 'normal', 'flying', 'Bird Pokemon', 1.09, 30, 'KeenEye TangledFeet', 3, 3, 3, 2, 2, 4, NULL, NULL, NULL, 1, -1, 1, NULL, NULL, 0, NULL, NULL, -1, 1, 0, NULL, NULL, NULL, NULL),
(18, 'Pidgeot', 'normal', 'flying', 'Bird Pokemon', 1.5, 39.5, 'KeenEye TangledFeet', 3, 4, 3, 3, 3, 5, NULL, NULL, NULL, 1, -1, 1, NULL, NULL, 0, NULL, NULL, -1, 1, 0, NULL, NULL, NULL, NULL),
(19, 'Rattata', 'normal', NULL, 'Mouse Pokemon', 0.3, 3.5, 'Guts RunAway', 2, 3, 2, 1, 2, 4, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(20, 'Raticate', 'normal', NULL, 'Mouse Pokemon', 0.71, 18.5, 'Guts RunAway', 2, 4, 3, 2, 3, 5, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(21, 'Spearow', 'normal', 'flying', 'Bird Pokemon', 0.3, 2, 'KeenEye Sniper', 2, 3, 2, 2, 1, 4, NULL, NULL, NULL, 1, -1, 1, NULL, NULL, 0, NULL, NULL, -1, 1, 0, NULL, NULL, NULL, NULL),
(22, 'Fearow', 'normal', 'flying', 'Bird Pokemon', 1.19, 38, 'KeenEye Sniper', 3, 5, 3, 3, 3, 5, NULL, NULL, NULL, 1, -1, 1, NULL, NULL, 0, NULL, NULL, -1, 1, 0, NULL, NULL, NULL, NULL),
(23, 'Ekans', 'poison', NULL, 'Snake Pokemon', 2.01, 6.9, 'Intimidate ShedSkin Unnerve', 2, 3, 2, 2, 2, 3, NULL, NULL, NULL, NULL, -1, NULL, -1, -1, 1, NULL, 1, -1, NULL, NULL, NULL, NULL, NULL, -1),
(24, 'Arbok', 'poison', NULL, 'Cobra Pokemon', 3.51, 65, 'Intimidate ShedSkin Unerve', 3, 4, 3, 3, 3, 4, NULL, NULL, NULL, NULL, -1, NULL, -1, -1, 1, NULL, 1, -1, NULL, NULL, NULL, NULL, NULL, -1),
(25, 'Pikachu', 'electric', NULL, 'Mouse Pokemon', 0.41, 6, 'Static LightningRod', 2, 3, 2, 2, 2, 5, NULL, NULL, NULL, -1, NULL, NULL, NULL, NULL, 1, -1, NULL, NULL, NULL, NULL, NULL, NULL, -1, NULL),
(26, 'Raichu', 'electric', NULL, 'Mouse Pokemon', 0.79, 30, 'Static LightningRod', 3, 5, 3, 4, 3, 6, NULL, NULL, NULL, -1, NULL, NULL, NULL, NULL, 1, -1, NULL, NULL, NULL, NULL, NULL, NULL, -1, NULL),
(27, 'Sandshrew', 'ground', NULL, 'Mouse Pokemon', 0.61, 12, 'SandVeil SandRush', 2, 4, 4, 1, 1, 2, NULL, NULL, 1, 0, 1, 1, NULL, -1, NULL, NULL, NULL, NULL, -1, NULL, NULL, NULL, NULL, NULL),
(28, 'Sandslash', 'ground', NULL, 'Mouse Pokemon', 0.99, 29.5, 'SandVeil SandRush', 3, 5, 5, 2, 2, 4, NULL, NULL, 1, 0, 1, 1, NULL, -1, NULL, NULL, NULL, NULL, -1, NULL, NULL, NULL, NULL, NULL),
(29, 'Nidoran♀', 'poison', NULL, 'Poison Pin Pokemon', 0.41, 7, 'PoisonPoint Rivalry Hustle', 2, 3, 2, 2, 2, 2, NULL, NULL, NULL, NULL, -1, NULL, -1, -1, 1, NULL, 1, -1, NULL, NULL, NULL, NULL, NULL, -1),
(30, 'Nidorina', 'poison', NULL, 'Poison Pin Pokemon', 0.79, 20, 'PoisonPoint Rivalry Hustle', 3, 3, 3, 3, 2, 3, NULL, NULL, NULL, NULL, -1, NULL, -1, -1, 1, NULL, 1, -1, NULL, NULL, NULL, NULL, NULL, -1),
(31, 'Nidoqueen', 'poison', 'ground', 'Drill Pokemon', 1.3, 60, 'PoisonPoint Rivalry SheerForce', 4, 5, 4, 4, 4, 4, NULL, NULL, 1, 0, NULL, 1, -1, -2, 1, NULL, 1, -1, -1, NULL, NULL, NULL, NULL, -1),
(32, 'Nidoran♂', 'poison', NULL, 'Poison Pin Pokemon', 0.51, 9, 'PoisonPoint Rivalry Hustle', 2, 3, 2, 2, 2, 3, NULL, NULL, NULL, NULL, -1, NULL, -1, -1, 1, NULL, 1, -1, NULL, NULL, NULL, NULL, NULL, -1),
(33, 'Nidorino', 'poison', NULL, 'Poison Pin Pokemon', 0.89, 19.5, 'PoisonPoint Rivalry Hustle', 3, 4, 3, 3, 2, 4, NULL, NULL, NULL, NULL, -1, NULL, -1, -1, 1, NULL, 1, -1, NULL, NULL, NULL, NULL, NULL, -1),
(34, 'Nidoking', 'poison', 'ground', 'Drill Pokemon', 1.4, 62, 'PoisonPoint Rivalry SheerForce', 3, 5, 3, 4, 3, 5, NULL, NULL, 1, 0, NULL, 1, -1, -2, 1, NULL, 1, -1, -1, NULL, NULL, NULL, NULL, -1),
(35, 'Clefairy', 'fairy', NULL, 'Fairy Pokemon', 0.61, 7.5, 'CuteCharm MagicGuard FriendGuard', 3, 2, 2, 3, 3, 2, NULL, NULL, NULL, NULL, NULL, NULL, -1, 1, NULL, NULL, NULL, -1, NULL, NULL, 0, -1, 1, NULL),
(36, 'Clefable', 'fairy', NULL, 'Fairy Pokemon', 1.3, 40, 'CuteCharm MagicGuard Unaware', 4, 4, 3, 5, 4, 3, NULL, NULL, NULL, NULL, NULL, NULL, -1, 1, NULL, NULL, NULL, -1, NULL, NULL, 0, -1, 1, NULL),
(37, 'Vulpix', 'fire', NULL, 'Fox Pokemon', 0.6, 9.9, 'FlashFire Drought', 2, 2, 2, 2, 3, 4, NULL, -1, 1, NULL, -1, -1, NULL, NULL, 1, NULL, NULL, -1, 1, NULL, NULL, NULL, -1, -1),
(38, 'Ninetales', 'fire', NULL, 'Fox Pokemon', 1.1, 19.9, 'FlashFire Drought', 3, 4, 3, 4, 4, 5, NULL, -1, 1, NULL, -1, -1, NULL, NULL, 1, NULL, NULL, -1, 1, NULL, NULL, NULL, -1, -1),
(39, 'Jigglypuff', 'normal', 'fairy', 'Balloon Pokemon', 0.5, 5.5, 'Competitive CuteCharm FriendGuard', 5, 2, 1, 2, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, -1, NULL, 0, 0, -1, 1, NULL),
(40, 'Wigglytuff', 'normal', 'fairy', 'Balloon Pokemon', 1, 12, 'Competitive CuteCharm Frisk', 5, 4, 2, 4, 2, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, -1, NULL, 0, 0, -1, 1, NULL),
(41, 'Zubat', 'poison', 'flying', 'Bat Pokemon', 0.8, 7.5, 'InnerFocus Infiltrator', 2, 2, 2, 1, 2, 3, NULL, NULL, NULL, 1, -2, 1, -2, -1, 0, NULL, 1, -2, 1, NULL, NULL, NULL, NULL, -1),
(42, 'Golbat', 'poison', 'flying', 'Bat Pokemon', 1.6, 55, 'InnerFocus Infiltrator', 3, 4, 3, 3, 3, 5, NULL, NULL, NULL, 1, -2, 1, -2, -1, 0, NULL, 1, -2, 1, NULL, NULL, NULL, NULL, -1),
(43, 'Oddish', 'grass', 'poison', 'Weed Pokemon', 0.5, 5.4, 'Chlorophyll RunAway', 2, 3, 3, 4, 3, 2, NULL, 1, -1, -1, -2, 1, -1, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, -1),
(44, 'Gloom', 'grass', 'poison', 'Weed Pokemon', 0.8, 8.6, 'Chlorophyll Stench', 3, 3, 3, 4, 3, 2, NULL, 1, -1, -1, -2, 1, -1, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, -1),
(45, 'Vileplume', 'grass', 'poison', 'Flower Pokemon', 1.2, 18.6, 'Chlorophyll EffectSpore', 3, 4, 4, 5, 4, 3, NULL, 1, -1, -1, -2, 1, -1, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, -1),
(46, 'Paras', 'bug', 'grass', 'Mushroom Pokemon', 0.3, 5.4, 'DrySkin EffectSpore Damp', 2, 4, 3, 2, 2, 2, NULL, 2, -1, -1, -2, 1, -1, 1, -2, 2, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(47, 'Parasect', 'bug', 'grass', 'Mushroom Pokemon', 1, 29.5, 'DrySkin EffectSpore Damp', 3, 5, 4, 3, 3, 2, NULL, 2, -1, -1, -2, 1, -1, 1, -2, 2, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(48, 'Venonat', 'bug', 'poison', 'Insect Pokemon', 1, 30, 'CompoundEyes TintedLens RunAway', 3, 3, 2, 2, 2, 3, NULL, 1, NULL, NULL, -2, NULL, -2, -1, NULL, 1, 1, -1, 1, NULL, NULL, NULL, NULL, -1),
(49, 'Venomoth', 'bug', 'poison', 'Poison Moth Pokemon', 1.5, 12.5, 'ShieldDust TintedLens WonderSkin', 3, 3, 3, 4, 3, 5, NULL, 1, NULL, NULL, -2, NULL, -2, -1, NULL, 1, 1, -1, 1, NULL, NULL, NULL, NULL, -1),
(50, 'Diglett', 'ground', NULL, 'Mole Pokemon', 0.2, 0.8, 'ArenaTrap SandVeil SandForce', 1, 3, 1, 2, 2, 5, NULL, NULL, 1, 0, 1, 1, NULL, -1, NULL, NULL, NULL, NULL, -1, NULL, NULL, NULL, NULL, NULL),
(51, 'Dugtrio', 'ground', NULL, 'Mole Pokemon', 0.7, 33.3, 'ArenaTrap SandVeil SandForce', 2, 4, 2, 2, 3, 6, NULL, NULL, 1, 0, 1, 1, NULL, -1, NULL, NULL, NULL, NULL, -1, NULL, NULL, NULL, NULL, NULL),
(52, 'Meowth', 'normal', NULL, 'Scratch Cat Pokemon', 0.4, 4.2, 'Pickup Technician Unnerve', 2, 2, 2, 2, 2, 5, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(53, 'Persian', 'normal', NULL, 'Classy Cat Pokemon', 1, 32, 'Limber Technician Unnerve', 3, 4, 3, 3, 3, 6, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(54, 'Psyduck', 'water', NULL, 'Duck Pokemon', 0.8, 19.6, 'CloudNine Damp SwiftSwim', 2, 3, 2, 3, 2, 3, NULL, -1, -1, 1, 1, -1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, -1, NULL),
(55, 'Golduck', 'water', NULL, 'Duck Pokemon', 1.7, 77.6, 'CloudNine Damp SwiftSwim', 3, 4, 3, 5, 3, 5, NULL, -1, -1, 1, 1, -1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, -1, NULL),
(56, 'Mankey', 'fighting', NULL, 'Pig Monkey Pokemon', 0.5, 28, 'AngerPoint VitalSpirit Defiant', 2, 4, 2, 2, 2, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, -1, -1, NULL, NULL, -1, NULL, 1),
(57, 'Primeape', 'fighting', NULL, 'Pig Monkey Pokemon', 1, 34, 'AngerPoint VitalSpirit Defiant', 3, 5, 3, 3, 3, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, -1, -1, NULL, NULL, -1, NULL, 1),
(58, 'Growlithe', 'fire', NULL, 'Puppy Pokemon', 0.7, 19, 'FlashFire Intimidate Justified', 2, 4, 2, 3, 2, 3, NULL, -1, 1, NULL, -1, -1, NULL, NULL, 1, NULL, NULL, -1, 1, NULL, NULL, NULL, -1, -1),
(59, 'Arcanine', 'fire', NULL, 'Legendary Pokemon', 1.9, 155, 'FlashFire Intimidate Justified', 4, 6, 4, 5, 3, 5, NULL, -1, 1, NULL, -1, -1, NULL, NULL, 1, NULL, NULL, -1, 1, NULL, NULL, NULL, -1, -1),
(60, 'Poliwag', 'water', NULL, 'Tadpole Pokemon', 0.6, 12.4, 'Damp WaterAbsorb SwiftSwim', 2, 3, 2, 2, 2, 5, NULL, -1, -1, 1, 1, -1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, -1, NULL),
(61, 'Poliwhirl', 'water', NULL, 'Tadpole Pokemon', 1, 20, 'Damp WaterAbsorb SwiftSwim', 3, 3, 3, 2, 2, 5, NULL, -1, -1, 1, 1, -1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, -1, NULL),
(62, 'Poliwrath', 'water', 'fighting', 'Tadpole Pokemon', 1.3, 54, 'Damp WaterAbsorb SwiftSwim', 4, 5, 4, 3, 4, 4, NULL, -1, -1, 1, 1, -1, NULL, NULL, NULL, 1, 1, -1, -1, NULL, NULL, -1, -1, 1),
(63, 'Abra', 'psychic', NULL, 'Psi Pokemon', 0.9, 19.5, 'InnerFocus Synchronize MagicGuard', 1, 1, 1, 5, 2, 5, NULL, NULL, NULL, NULL, NULL, NULL, -1, NULL, NULL, NULL, -1, 1, NULL, 1, NULL, 1, NULL, NULL),
(64, 'Kadabra', 'psychic', NULL, 'Psi Pokemon', 1.3, 56.5, 'InnerFocus Synchronize MagicGuard', 2, 2, 2, 6, 3, 6, NULL, NULL, NULL, NULL, NULL, NULL, -1, NULL, NULL, NULL, -1, 1, NULL, 1, NULL, 1, NULL, NULL),
(65, 'Alakazam', 'psychic', NULL, 'Psi Pokemon', 1.5, 48, 'InnerFocus Synchronize MagicGuard', 2, 3, 2, 7, 4, 6, NULL, NULL, NULL, NULL, NULL, NULL, -1, NULL, NULL, NULL, -1, 1, NULL, 1, NULL, 1, NULL, NULL),
(66, 'Machop', 'fighting', NULL, 'Superpower Pokemon', 0.8, 19.5, 'Guts NoGuard Steadfast', 3, 4, 2, 2, 2, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, -1, -1, NULL, NULL, -1, NULL, 1),
(67, 'Machoke', 'fighting', NULL, 'Superpower Pokemon', 1.5, 70.5, 'Guts NoGuard Steadfast', 3, 5, 3, 2, 3, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, -1, -1, NULL, NULL, -1, NULL, 1),
(68, 'Machamp', 'fighting', NULL, 'Superpower Pokemon', 1.6, 130, 'Guts NoGuard Steadfast', 4, 7, 4, 3, 4, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, -1, -1, NULL, NULL, -1, NULL, 1),
(69, 'Bellsprout', 'grass', 'poison', 'Flower Pokemon', 0.7, 4, 'Chlorophyll Gluttony', 2, 4, 2, 3, 1, 2, NULL, 1, -1, -1, -2, 1, -1, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, -1),
(70, 'Weepinbell', 'grass', 'poison', 'Flycather Pokemon', 1, 6.4, 'Chlorophyll Gluttony', 3, 5, 2, 4, 2, 3, NULL, 1, -1, -1, -2, 1, -1, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, -1),
(71, 'Victreebel', 'grass', 'poison', 'Flycather Pokemon', 1.7, 15.5, 'Chlorophyll Gluttony', 3, 5, 3, 5, 3, 4, NULL, 1, -1, -1, -2, 1, -1, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, -1),
(72, 'Tentacool', 'water', 'poison', 'Jellyfish Pokemon', 0.9, 45.5, 'ClearBody LiquidOoze RainDish', 2, 2, 2, 2, 4, 4, NULL, -1, -1, 1, NULL, -1, -1, -1, 1, NULL, 1, -1, NULL, NULL, NULL, NULL, -1, -1),
(73, 'Tentacruel', 'water', 'poison', 'Jellyfish Pokemon', 1.6, 55, 'ClearBody LiquidOoze RainDish', 3, 4, 3, 4, 5, 5, NULL, -1, -1, 1, NULL, -1, -1, -1, 1, NULL, 1, -1, NULL, NULL, NULL, NULL, -1, -1),
(74, 'Geodude', 'rock', 'ground', 'Rock Pokemon', 0.4, 20, 'RockHead Sturdy SandVeil', 2, 4, 4, 1, 1, 1, -1, -1, 2, 0, 2, 1, 1, -2, 1, -1, NULL, NULL, -1, NULL, NULL, NULL, 1, NULL),
(75, 'Graveler', 'rock', 'ground', 'Rock Pokemon', 1, 105, 'RockHead Sturdy SandVeil', 2, 5, 5, 2, 2, 2, -1, -1, 2, 0, 2, 1, 1, -2, 1, -1, NULL, NULL, -1, NULL, NULL, NULL, 1, NULL),
(76, 'Golem', 'rock', 'ground', 'Megaton Pokemon', 1.4, 300, 'RockHead Sturdy SandVeil', 3, 6, 6, 3, 3, 3, -1, -1, 2, 0, 2, 1, 1, -2, 1, -1, NULL, NULL, -1, NULL, NULL, NULL, 1, NULL),
(77, 'Ponyta', 'fire', NULL, 'Fire Horse Pokemon', 1, 30, 'FlashFire RunAway FlameBody', 2, 4, 3, 3, 3, 5, NULL, -1, 1, NULL, -1, -1, NULL, NULL, 1, NULL, NULL, -1, 1, NULL, NULL, NULL, -1, -1),
(78, 'Rapidash', 'fire', NULL, 'Fire Horse Pokemon', 1.7, 95, 'FlashFire RunAway FlameBody', 3, 5, 3, 4, 3, 6, NULL, -1, 1, NULL, -1, -1, NULL, NULL, 1, NULL, NULL, -1, 1, NULL, NULL, NULL, -1, -1),
(79, 'Slowpoke', 'water', 'psychic', 'Dopey Pokemon', 1.2, 36, 'Oblivious OwnTempo Regenerator', 4, 3, 3, 2, 2, 1, NULL, -1, -1, 1, 1, -1, -1, NULL, NULL, NULL, -1, 1, NULL, 1, NULL, 1, -1, NULL),
(80, 'Slowbro', 'water', 'psychic', 'Hermit Crab Pokemon', 1.6, 78.5, 'Oblivious OwnTempo Regenerator', 4, 4, 5, 5, 3, 2, NULL, -1, -1, 1, 1, -1, -1, NULL, NULL, NULL, -1, 1, NULL, 1, NULL, 1, -1, NULL),
(81, 'Magnemite', 'electric', 'steel', 'Magnet Pokemon', 0.3, 6, 'MagnetPull Sturdy Analytic', 1, 2, 3, 5, 2, 3, -1, 1, NULL, -1, -1, -1, 1, 0, 2, -2, -1, -1, -1, NULL, -1, NULL, -2, -1),
(82, 'Magneton', 'electric', 'steel', 'Magnet Pokemon', 1, 60, 'MagnetPull Sturdy Analytic', 2, 3, 4, 6, 3, 4, -1, 1, NULL, -1, -1, -1, 1, 0, 2, -2, -1, -1, -1, NULL, -1, NULL, -2, -1),
(83, 'Farfetchd', 'normal', 'flying', 'Wild Duck Pokemon', 0.8, 15, 'InnerFocus KeenEye Defiant', 2, 3, 3, 3, 3, 3, NULL, NULL, NULL, 1, -1, 1, NULL, NULL, 0, NULL, NULL, -1, 1, 0, NULL, NULL, NULL, NULL),
(84, 'Doduo', 'normal', 'flying', 'Twin Bird Pokemon', 1.4, 39.2, 'EarlyBird RunAway TangledFeet', 2, 4, 2, 2, 2, 4, NULL, NULL, NULL, 1, -1, 1, NULL, NULL, NULL, NULL, NULL, -1, 1, 0, NULL, 0, NULL, NULL),
(85, 'Dodrio', 'normal', 'flying', 'Triple Bird Pokemon', 1.8, 85.2, 'EarlyBird RunAway TangledFeet', 3, 6, 3, 3, 3, 5, NULL, NULL, NULL, 1, -1, 1, NULL, NULL, NULL, NULL, NULL, -1, 1, 0, NULL, 0, NULL, NULL),
(86, 'Seel', 'water', NULL, 'Sea Lion Pokemon', 1.1, 90, 'Hydration ThickFat IceBody', 3, 2, 3, 2, 3, 3, NULL, -1, -1, 1, 1, -1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, -1, NULL),
(87, 'Dewgong', 'water', 'ice', 'Sea Lion Pokemon', 1.7, 120, 'Hydration ThickFat IceBody', 4, 4, 4, 3, 4, 4, NULL, NULL, -1, 1, 1, -2, 1, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL),
(88, 'Grimer', 'poison', NULL, 'Sludge Pokemon', 0.9, 30, 'Stench StickyHold PoisonTouch', 3, 4, 2, 2, 2, 2, NULL, NULL, NULL, NULL, -1, NULL, -1, -1, 1, NULL, 1, -1, NULL, NULL, NULL, NULL, NULL, -1),
(89, 'Muk', 'poison', NULL, 'Sludge Pokemon', 1.2, 30, 'Stench StickyHold PoisonTouch', 4, 5, 3, 3, 4, 3, NULL, NULL, NULL, NULL, -1, NULL, -1, -1, 1, NULL, 1, -1, NULL, NULL, NULL, NULL, NULL, -1),
(90, 'Shellder', 'water', NULL, 'Bivalve Pokemon', 0.3, 4, 'ShellArmor SkillLink Overcoat', 2, 3, 4, 2, 1, 2, NULL, -1, -1, 1, 1, -1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, -1, NULL),
(91, 'Cloyster', 'water', 'ice', 'Bivalve Pokemon', 1.5, 132.5, 'ShellArmor SkillLink Overcoat', 2, 5, 8, 4, 2, 4, NULL, NULL, -1, 1, 1, -2, 1, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL),
(92, 'Gastly', 'ghost', 'poison', 'Gas Pokemon', 1.3, 0.1, 'Levitate', 2, 2, 2, 5, 2, 4, 0, NULL, NULL, NULL, -1, NULL, 0, -2, 0, NULL, 1, -2, NULL, 1, NULL, 1, NULL, -1),
(93, 'Haunter', 'ghost', 'poison', 'Gas Pokemon', 1.6, 0.1, 'Levitate', 2, 3, 2, 6, 2, 5, 0, NULL, NULL, NULL, -1, NULL, 0, -2, 0, NULL, 1, -2, NULL, 1, NULL, 1, NULL, -1),
(94, 'Gengar', 'ghost', 'poison', 'Shadow Pokemon', 1.5, 40.5, 'CursedBody', 3, 3, 3, 6, 3, 6, 0, NULL, NULL, NULL, -1, NULL, 0, -2, 1, NULL, 1, -2, NULL, 1, NULL, 1, NULL, -1),
(95, 'Onix', 'rock', 'ground', 'Rock Snake Pokemon', 8.8, 210, 'RockHead Sturdy WeakArmor', 2, 2, 7, 1, 2, 4, -1, -1, 2, 0, 2, 1, 1, -2, 1, -1, NULL, NULL, -1, NULL, NULL, NULL, 1, NULL),
(96, 'Drowzee', 'psychic', NULL, 'Hypnosis Pokemon', 1, 32.4, 'Forewarn Insomnia InnerFocus', 3, 3, 2, 2, 4, 2, NULL, NULL, NULL, NULL, NULL, NULL, -1, NULL, NULL, NULL, -1, 2, NULL, 2, NULL, 2, NULL, NULL),
(97, 'Hypno', 'psychic', NULL, 'Hypnosis Pokemon', 1.6, 75.6, 'Forewarn Insomnia InnerFocus', 3, 4, 3, 4, 5, 4, NULL, NULL, NULL, NULL, NULL, NULL, -1, NULL, NULL, NULL, -1, 2, NULL, 2, NULL, 2, NULL, NULL),
(98, 'Krabby', 'water', NULL, 'River Crab Pokemon', 0.4, 6.5, 'HyperCutter ShellArmor SheerForce', 2, 5, 4, 1, 1, 3, NULL, -1, -1, 1, 1, -1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, -1, NULL),
(99, 'Kingler', 'water', NULL, 'Pincer Pokemon', 1.3, 60, 'HyperCutter ShellArmor SheerForce', 2, 7, 5, 2, 2, 4, NULL, -1, -1, 1, 1, -1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, -1, NULL),
(100, 'Voltorb', 'electric', NULL, 'Ball Pokemon', 0.5, 10.4, 'Soundproof Static Aftermath', 2, 2, 2, 3, 2, 5, NULL, NULL, NULL, -1, NULL, NULL, NULL, NULL, 1, -1, NULL, NULL, NULL, NULL, NULL, NULL, -1, NULL),
(101, 'Electrode', 'electric', NULL, 'Ball Pokemon', 1.2, 66.6, 'Soundproof Static Aftermath', 3, 3, 3, 4, 3, 7, NULL, NULL, NULL, -1, NULL, NULL, NULL, NULL, 1, -1, NULL, NULL, NULL, NULL, NULL, NULL, -1, NULL),
(102, 'Exeggcute', 'grass', 'psychic', 'Egg Pokemon', 0.4, 2.5, 'Chlorophyll Harvest', 3, 2, 4, 3, 2, 2, NULL, 1, -1, -1, -1, 1, NULL, 1, -1, 1, -1, 2, NULL, 1, NULL, 1, NULL, NULL),
(103, 'Exeggutor', 'grass', 'psychic', 'Coconut Pokemon', 2, 120, 'Chlorophyll Harvest', 4, 5, 4, 6, 3, 3, NULL, 1, -1, -1, -1, 1, NULL, 1, -1, 1, -1, 2, NULL, 1, NULL, 1, NULL, NULL),
(104, 'Cubone', 'ground', NULL, 'Lonely Pokemon', 0.4, 6.5, 'LightningRod RockHead BattleArmor', 2, 3, 4, 2, 2, 2, NULL, NULL, 1, 0, 1, 1, NULL, -1, -1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(105, 'Marowak', 'ground', NULL, 'Bone Keeper Pokemon', 1, 45, 'LightningRod RockHead BattleArmor', 3, 4, 5, 2, 3, 3, NULL, NULL, 1, 0, 1, 1, NULL, -1, -1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(106, 'Hitmonlee', 'fighting', NULL, 'Kicking Pokemon', 1.5, 49.8, 'Limber Reckless Unburden', 2, 6, 2, 2, 5, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, -1, -1, NULL, NULL, -1, NULL, 1),
(107, 'Hitmonchan', 'fighting', NULL, 'Punching Pokemon', 1.4, 50.2, 'IronFist KeenEye InnerFocus', 2, 5, 3, 2, 5, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, -1, -1, NULL, NULL, -1, NULL, 1),
(108, 'Lickitung', 'normal', NULL, 'Licking Pokemon', 1.2, 65.5, 'Oblivious OwnTempo CloudNine', 4, 3, 3, 3, 3, 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(109, 'Koffing', 'poison', NULL, 'Poison Gas Pokemon', 0.6, 1, 'Levitate', 2, 3, 4, 3, 2, 2, NULL, NULL, NULL, NULL, -1, NULL, -1, -1, 0, NULL, 2, -1, NULL, NULL, NULL, NULL, NULL, -1),
(110, 'Weezing', 'poison', NULL, 'Poison Gas Pokemon', 1.2, 9.5, 'Levitate', 3, 5, 5, 4, 3, 3, NULL, NULL, NULL, NULL, -1, NULL, -1, -1, 0, NULL, 2, -1, NULL, NULL, NULL, NULL, NULL, -1),
(111, 'Rhyhorn', 'ground', 'rock', 'Spikes Pokemon', 1, 115, 'LightningRod RockHead Reckless', 3, 4, 4, 1, 1, 2, -1, -1, 2, 0, 2, 1, 1, -2, 1, -1, NULL, NULL, -1, NULL, NULL, NULL, 1, NULL),
(112, 'Rhydon', 'ground', 'rock', 'Drill Pokemon', 1.9, 120, 'LightningRod RockHead Reckless', 4, 7, 5, 2, 2, 2, -1, -1, 2, 0, 2, 1, 1, -2, 1, -1, NULL, NULL, -1, NULL, NULL, NULL, 1, NULL),
(113, 'Chansey', 'normal', NULL, 'Egg Pokemon', 1.1, 34.6, 'NaturalCure SereneGrace Healer', 9, 1, 1, 2, 4, 3, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(114, 'Tangela', 'grass', NULL, 'Vine Pokemon', 1, 35, 'Chlorophyll LeafGuard Regenerator', 3, 3, 5, 5, 2, 3, NULL, 1, -1, -1, -1, 1, NULL, 1, -1, 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(115, 'Kangaskhan', 'normal', NULL, 'Parent Pokemon', 2.2, 80, 'EarlyBird Scrappy InnerFocus', 4, 5, 4, 2, 3, 5, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(116, 'Horsea', 'water', NULL, 'Dragon Pokemon', 0.4, 8, 'Sniper SwiftSwim Damp', 2, 2, 3, 3, 1, 3, NULL, -1, -1, 1, 1, -1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, -1, NULL),
(117, 'Seadra', 'water', NULL, 'Dragon Pokemon', 1.2, 25, 'Sniper PoisonPoint Damp', 2, 3, 4, 5, 2, 5, NULL, -1, -1, 1, 1, -1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, -1, NULL),
(118, 'Goldeen', 'water', NULL, 'Goldfish Pokemon', 0.6, 15, 'SwiftSwim WaterVeil LightningRod', 2, 4, 3, 2, 2, 3, NULL, -1, -1, 1, 1, -1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, -1, NULL),
(119, 'Seaking', 'water', NULL, 'Goldfish Pokemon', 1.3, 39, 'SwiftSwim WaterVeil LightningRod', 3, 5, 3, 3, 3, 4, NULL, -1, -1, 1, 1, -1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, -1, NULL),
(120, 'Staryu', 'water', NULL, 'Star Shape Pokemon', 0.8, 34.5, 'Illuminate NaturalCure Analytic', 2, 2, 3, 3, 2, 5, NULL, -1, -1, 1, 1, -1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, -1, NULL),
(121, 'Starmie', 'water', 'psychic', 'Mysterious Pokemon', 1.1, 80, 'Illuminate NaturalCure Analytic', 3, 4, 4, 5, 4, 6, NULL, -1, -1, 1, 1, -1, -1, NULL, NULL, NULL, -1, 1, NULL, 1, NULL, 1, -1, NULL),
(122, 'Mr-Mime', 'psychic', 'fairy', 'Barrier Pokemon', 1.3, 54.5, 'Filter Soundproof Technician', 2, 2, 3, 5, 5, 5, NULL, NULL, NULL, NULL, NULL, NULL, -2, 1, NULL, NULL, -1, NULL, NULL, 1, 0, NULL, 1, NULL),
(123, 'Scyther', 'bug', 'flying', 'Mantis Pokemon', 1.5, 56, 'Swarm Technician Steadfast', 3, 6, 4, 3, 3, 6, NULL, 1, NULL, 1, -2, 1, -2, NULL, 0, 1, NULL, -1, 2, NULL, NULL, NULL, NULL, NULL),
(124, 'Jynx', 'ice', 'psychic', 'Human Shape Pokemon', 1.4, 40.6, 'Forewarn Oblivious DrySkin', 3, 3, 2, 6, 4, 5, NULL, 1, NULL, NULL, NULL, -1, NULL, NULL, NULL, NULL, -1, 1, 1, 1, NULL, 1, 1, NULL),
(125, 'Electabuzz', 'electric', NULL, 'Electric Pokemon', 1.1, 30, 'Static VitalSpirit', 3, 4, 3, 5, 4, 6, NULL, NULL, NULL, -1, NULL, NULL, NULL, NULL, 1, -1, NULL, NULL, NULL, NULL, NULL, NULL, -1, NULL),
(126, 'Magmar', 'fire', NULL, 'Spitfire Pokemon', 1.3, 44.5, 'FlameBody VitalSpirit', 3, 5, 3, 5, 4, 5, NULL, -1, 1, NULL, -1, -1, NULL, NULL, 1, NULL, NULL, -1, 1, NULL, NULL, NULL, -1, -1),
(127, 'Pinsir', 'bug', NULL, 'Stag Beetle Pokemon', 1.5, 55, 'HyperCutter MoldBreaker Moxie', 3, 6, 4, 3, 3, 5, NULL, 1, NULL, NULL, -1, NULL, -1, NULL, -1, 1, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL),
(128, 'Tauros', 'normal', NULL, 'Wild Bull Pokemon', 1.4, 88.4, 'Intimidate AngerPoint SheerForce', 3, 5, 4, 2, 3, 6, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(129, 'Magikarp', 'water', NULL, 'Fish Pokemon', 0.9, 10, 'SwiftSwim Rattled', 1, 1, 3, 1, 1, 4, NULL, -1, -1, 1, 1, -1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, -1, NULL),
(130, 'Gyarados', 'water', 'flying', 'Atrocious Pokemon', 6.5, 235, 'Intimidate Moxie', 4, 6, 3, 3, 4, 4, NULL, -1, -1, 2, NULL, NULL, -1, NULL, 0, NULL, NULL, -1, 1, NULL, NULL, NULL, -1, NULL),
(131, 'Lapras', 'water', 'ice', 'Transport Pokemon', 2.5, 220, 'WaterAbsorb ShellArmor Hydration', 5, 4, 4, 4, 4, 3, NULL, NULL, -1, 1, 1, -2, 1, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL),
(132, 'Ditto', 'normal', NULL, 'Transform Pokemon', 0.3, 4, 'Limber Imposter', 2, 3, 2, 2, 2, 3, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(133, 'Eevee', 'normal', NULL, 'Evolution Pokemon', 0.3, 6.5, 'RunAway Adaptability Anticipation', 2, 3, 2, 2, 3, 3, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(134, 'Vaporeon', 'water', NULL, 'Bubble Jet Pokemon', 1, 29, 'WaterAbsorb Hydration', 5, 3, 3, 5, 4, 4, NULL, -1, -1, 1, 1, -1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, -1, NULL),
(135, 'Jolteon', 'electric', NULL, 'Lightning Pokemon', 0.8, 24.5, 'VoltAbsorb QuickFeet', 3, 3, 3, 5, 4, 7, NULL, NULL, NULL, -1, NULL, NULL, NULL, NULL, 1, -1, NULL, NULL, NULL, NULL, NULL, NULL, -1, NULL),
(136, 'Flareon', 'fire', NULL, 'Flame Pokemon', 0.9, 25, 'FlashFire Guts', 3, 7, 3, 5, 5, 4, NULL, -1, 1, NULL, -1, -1, NULL, NULL, 1, NULL, NULL, -1, 1, NULL, NULL, NULL, -1, -1),
(137, 'Porygon', 'normal', NULL, 'Virtual Pokemon', 0.8, 36.5, 'Trace Download Analytic', 3, 3, 3, 4, 3, 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(138, 'Omanyte', 'rock', 'water', 'Spiral Pokemon', 0.4, 7.5, 'SwiftSwim ShellArmor WeakArmor', 2, 2, 4, 4, 2, 2, -1, -2, NULL, 1, 2, -1, 1, -1, 1, -1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(139, 'Omastar', 'rock', 'water', 'Spiral Pokemon', 1, 35, 'SwiftSwim ShellArmor WeakArmor', 3, 3, 5, 6, 3, 3, -1, -2, NULL, 1, 2, -1, 1, -1, 1, -1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(140, 'Kabuto', 'rock', 'water', 'Shellfish Pokemon', 0.5, 11.5, 'SwiftSwim BattleArmor WeakArmor', 2, 4, 4, 3, 2, 3, -1, -2, NULL, 1, 2, -1, 1, -1, 1, -1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(141, 'Kabutops', 'rock', 'water', 'Shellfish Pokemon', 1.3, 40.5, 'SwiftSwim BattleArmor WeakArmor', 3, 6, 5, 3, 3, 4, -1, -2, NULL, 1, 2, -1, 1, -1, 1, -1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(142, 'Aerodactyl', 'rock', 'flying', 'Fossil Pokemon', 1.8, 59, 'RockHead Pressure Unnerve', 3, 5, 3, 3, 3, 7, -1, -1, 1, 1, NULL, 1, NULL, -1, 0, -1, NULL, -1, 1, NULL, NULL, NULL, 1, NULL),
(143, 'Snorlax', 'normal', NULL, 'Sleeping Pokemon', 2.1, 460, 'Immunity ThickFat Gluttony', 6, 6, 3, 3, 5, 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(144, 'Articuno', 'ice', 'flying', 'Freeze Pokemon', 1.7, 55.4, 'Pressure SnowCloak', 4, 4, 4, 5, 5, 5, NULL, 1, NULL, 1, -1, NULL, NULL, NULL, 0, NULL, NULL, -1, 2, NULL, NULL, NULL, 1, NULL),
(145, 'Zapdos', 'electric', 'flying', 'Electric Pokemon', 1.6, 52.6, 'Pressure Static', 4, 5, 4, 6, 4, 5, NULL, NULL, NULL, NULL, -1, 1, -1, NULL, 0, -1, NULL, -1, 1, NULL, NULL, NULL, -1, NULL),
(146, 'Moltres', 'fire', 'flying', 'Flame Pokemon', 2, 60, 'Pressure FlameBody', 4, 5, 4, 6, 4, 5, NULL, -1, 1, 1, -2, NULL, -1, NULL, 0, NULL, NULL, -2, 2, NULL, NULL, NULL, -1, -1),
(147, 'Dratini', 'dragon', NULL, 'Dragon Pokemon', 1.8, 3.3, 'ShedSkin MarvelScale', 2, 3, 2, 2, 2, 3, NULL, -1, -1, -1, -1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 1),
(148, 'Dragonair', 'dragon', NULL, 'Dragon Pokemon', 4, 16.5, 'ShedSkin MarvelScale', 3, 4, 3, 3, 3, 4, NULL, -1, -1, -1, -1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 1),
(149, 'Dragonite', 'dragon', 'flying', 'Dragon Pokemon', 2.2, 210, 'InnerFocus Multiscale', 4, 7, 4, 5, 4, 4, NULL, -1, -1, NULL, -2, 2, -1, NULL, 0, NULL, NULL, -1, 1, NULL, 1, NULL, NULL, 1),
(150, 'Mewtwo', 'psychic', NULL, 'Genetic Pokemon', 2, 122, 'Pressure Unnerve', 4, 6, 4, 8, 4, 7, NULL, NULL, NULL, NULL, NULL, NULL, -1, NULL, NULL, NULL, -1, 1, NULL, 1, NULL, 1, NULL, NULL),
(151, 'Mew', 'psychic', NULL, 'New Species Pokemon', 0.4, 4, 'Synchronize', 4, 5, 4, 5, 4, 5, NULL, NULL, NULL, NULL, NULL, NULL, -1, NULL, NULL, NULL, -1, 1, NULL, 1, NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pokemons`
--

CREATE TABLE `pokemons` (
  `id` int(11) NOT NULL,
  `playerid` int(11) DEFAULT NULL,
  `pokenumber` int(11) DEFAULT NULL,
  `attack1` int(11) DEFAULT NULL,
  `attack2` int(11) DEFAULT NULL,
  `attack3` int(11) DEFAULT NULL,
  `attack4` int(11) DEFAULT NULL,
  `attack5` int(11) DEFAULT NULL,
  `attack6` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `pokemons`
--

INSERT INTO `pokemons` (`id`, `playerid`, `pokenumber`, `attack1`, `attack2`, `attack3`, `attack4`, `attack5`, `attack6`) VALUES
(1, 1, 34, 86, 72, 77, 77, 73, 82),
(2, 1, 73, 22, 28, 30, 24, 72, 77),
(3, 1, 76, 126, 125, 122, 129, 128, 86),
(4, 1, 112, 89, 82, 86, 125, 128, 121),
(5, 1, 139, 22, 30, 25, 126, 122, 21),
(6, 1, 141, 122, 10, 123, 28, 28, 26),
(20, 3, 87, 28, 22, 23, 51, 59, 54),
(21, 3, 91, 28, 30, 25, 10, 54, 60),
(22, 3, 121, 21, 22, 30, 101, 102, 108),
(23, 3, 124, 55, 52, 51, 101, 102, 109),
(24, 3, 97, 109, 107, 105, 101, 102, 103),
(25, 3, 65, 101, 102, 103, 109, 107, 105),
(26, 4, 9, 10, 8, 22, 22, 30, 30),
(27, 4, 57, 61, 62, 63, 65, 69, 68),
(28, 4, 62, 28, 10, 65, 66, 68, 69),
(29, 4, 68, 63, 65, 66, 68, 69, 70),
(30, 4, 106, 62, 65, 66, 68, 69, 70),
(31, 4, 107, 61, 65, 66, 68, 69, 70),
(32, 5, 28, 82, 82, 83, 89, 2, 4),
(33, 5, 76, 121, 89, 123, 126, 129, 128),
(34, 5, 112, 126, 129, 128, 130, 89, 122),
(35, 5, 139, 22, 22, 23, 26, 30, 126),
(36, 5, 141, 28, 28, 30, 130, 26, 7),
(37, 5, 142, 7, 98, 92, 100, 121, 122),
(38, 6, 3, 43, 47, 47, 49, 45, 75),
(39, 6, 15, 111, 72, 112, 72, 120, 7),
(40, 6, 47, 119, 120, 113, 42, 42, 7),
(41, 6, 71, 42, 50, 45, 47, 49, 42),
(42, 6, 123, 120, 112, 111, 7, 119, 111),
(43, 6, 127, 120, 113, 119, 112, 9, 7),
(44, 7, 6, 11, 12, 13, 7, 6, 12),
(45, 7, 59, 11, 14, 13, 7, 2, 14),
(46, 7, 126, 11, 12, 13, 7, 14, 9),
(47, 7, 26, 31, 34, 33, 7, 38, 2),
(48, 7, 135, 31, 32, 33, 7, 37, 39),
(49, 7, 125, 31, 32, 33, 7, 37, 39),
(50, 8, 3, 75, 80, 74, 47, 47, 78),
(51, 8, 45, 75, 80, 74, 47, 47, 78),
(52, 8, 31, 77, 80, 73, 9, 9, 78),
(53, 8, 73, 75, 80, 74, 5, 5, 78),
(54, 8, 89, 75, 80, 73, 10, 10, 78),
(55, 8, 110, 75, 80, 73, 79, 9, 78),
(56, 9, 82, 164, 164, 163, 6, 164, 9),
(57, 9, 82, 164, 164, 163, 6, 164, 9),
(58, 9, 94, 135, 132, 133, 7, 9, 132),
(59, 9, 94, 135, 132, 133, 7, 9, 132),
(60, 9, 148, 141, 142, 143, 148, 149, 144),
(61, 9, 149, 141, 142, 143, 144, 148, 149);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `attackdex`
--
ALTER TABLE `attackdex`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `pokedex`
--
ALTER TABLE `pokedex`
  ADD PRIMARY KEY (`number`);

--
-- Indeksy dla tabeli `pokemons`
--
ALTER TABLE `pokemons`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `attackdex`
--
ALTER TABLE `attackdex`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=181;

--
-- AUTO_INCREMENT dla tabeli `players`
--
ALTER TABLE `players`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT dla tabeli `pokedex`
--
ALTER TABLE `pokedex`
  MODIFY `number` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- AUTO_INCREMENT dla tabeli `pokemons`
--
ALTER TABLE `pokemons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
