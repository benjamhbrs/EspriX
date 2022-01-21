-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 14, 2021 at 10:15 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `modal`
--

-- --------------------------------------------------------

--
-- Table structure for table `commentaires`
--

CREATE TABLE `commentaires` (
  `id_topic` int(11) NOT NULL,
  `content` varchar(2000) NOT NULL,
  `date` datetime NOT NULL,
  `id_prec` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `pseudo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `commentaires`
--

INSERT INTO `commentaires` (`id_topic`, `content`, `date`, `id_prec`, `id`, `pseudo`) VALUES
(43, 'J\'ai grandement apprécié, franchement bravo !', '2021-11-12 11:31:45', -1, 114, 'Camus'),
(41, 'De toute beauté !', '2021-11-12 11:32:12', -1, 115, 'Camus'),
(45, 'J\'aurais ici aimé transposer cette réflexion à la race canine.', '2021-11-12 11:34:53', -1, 116, 'Camus'),
(42, 'Magnifique très cher !', '2021-11-12 11:35:22', -1, 117, 'Camus'),
(42, 'Merci bien !', '2021-11-12 11:36:10', 117, 118, 'Baudelaire'),
(41, 'Merci !!', '2021-11-12 11:36:50', 115, 119, 'Baudelaire'),
(45, 'C\'est en cours d\'écriture !', '2021-11-12 11:37:19', -1, 120, 'Baudelaire'),
(44, 'Hautement pertinent !', '2021-11-12 11:38:29', -1, 121, 'Baudelaire'),
(44, 'C\'est également mon avis !', '2021-11-12 17:05:12', 121, 122, 'bob'),
(46, 'J\'adore !', '2021-11-12 18:09:04', -1, 123, 'alice'),
(46, 'C\'est franchement du génie !', '2021-11-12 18:09:27', -1, 124, 'alice'),
(46, 'Tu l\'as dis !', '2021-11-12 18:10:53', 124, 125, 'bob'),
(63, 'Que le débat commence !', '2021-11-12 20:47:35', -1, 126, 'alice'),
(45, 'je suis en train de tester ce site, il est vraiment formidable !!', '2021-11-12 20:51:27', -1, 127, 'bob'),
(63, 'Y\'a quelqu\'un ?', '2021-11-14 01:17:31', 126, 128, 'alice'),
(63, 'Allo ?', '2021-11-14 01:17:39', -1, 129, 'alice'),
(63, 'Bon ça commence à m\'énerver ', '2021-11-14 01:18:07', -1, 130, 'alice'),
(63, 'Je me tire ciao les loosers', '2021-11-14 01:18:24', -1, 131, 'alice'),
(63, 'C\'est ca ouais tire toi', '2021-11-14 01:19:28', 131, 132, 'bob'),
(63, 'Bouffonne va', '2021-11-14 01:19:41', 131, 133, 'bob'),
(63, 'Oh mais tes qui toi ?\r\n', '2021-11-14 01:20:04', 131, 134, 'alice'),
(63, 'Tu cherches les embrouilles ?', '2021-11-14 01:20:39', 131, 135, 'alice'),
(63, 'Jvais ramener mes cousins sois en prévenu', '2021-11-14 01:21:04', 131, 136, 'alice'),
(69, 'Franchement c\'est une question non ?', '2021-11-14 02:04:09', -1, 139, 'alice'),
(69, 'non', '2021-11-14 02:05:08', 139, 140, 'bob'),
(69, 'Fin', '2021-11-14 02:05:28', 139, 141, 'bob'),
(69, 'Comment dire', '2021-11-14 02:05:39', 139, 142, 'bob'),
(69, 'apprends à parler franchement', '2021-11-14 02:13:31', 139, 143, 'alice'),
(69, 'parle mieux stp', '2021-11-14 02:14:23', 139, 144, 'bob'),
(79, 'love it', '2021-11-14 17:45:42', -1, 147, 'bob'),
(85, 'Sujet croustillant !', '2021-11-14 18:27:57', -1, 148, 'alice'),
(85, 'Cela n\'est pas très clair, qu\'est ce donc que ce texte ?\r\nLisez un peu Baudelaire, recevez ma lumière.', '2021-11-14 18:29:39', -1, 149, 'Baudelaire'),
(85, 'Ce ne sont pas ces complaisances qui vous feront sortir de l\'absurde par la révolte...', '2021-11-14 18:31:29', 148, 150, 'Camus'),
(85, 'Ach mein Freund, die Vereinigten Staaten von Amerika sind ein komisches Land...', '2021-11-14 18:36:22', 150, 151, 'Kant'),
(79, 'merci l\'ami !', '2021-11-14 22:01:09', -1, 157, 'alice'),
(42, 'Tu me sors de ma déprime mon frère, j\'espère que ce lieu existe !!!!!', '2021-11-14 22:11:09', 118, 158, 'camus');

-- --------------------------------------------------------

--
-- Table structure for table `textes`
--

CREATE TABLE `textes` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(30) NOT NULL,
  `title` varchar(100) NOT NULL,
  `date` date DEFAULT NULL,
  `summary` varchar(5000) DEFAULT NULL,
  `main` varchar(10000) NOT NULL,
  `comment` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `textes`
--

INSERT INTO `textes` (`id`, `pseudo`, `title`, `date`, `summary`, `main`, `comment`) VALUES
(64, 'Baudelaire', 'L’Albatros', '1857-08-23', 'Un oiseau qui nous nous suit ...', 'Souvent, pour s\'amuser, les hommes d\'équipage\r\nPrennent des albatros, vastes oiseaux des mers,\r\nQui suivent, indolents compagnons de voyage,\r\nLe navire glissant sur les gouffres amers.\r\n\r\nA peine les ont-ils déposés sur les planches,\r\nQue ces rois de l\'azur, maladroits et honteux,\r\nLaissent piteusement leurs grandes ailes blanches\r\nComme des avirons traîner à côté d\'eux.\r\n\r\nCe voyageur ailé, comme il est gauche et veule !\r\nLui, naguère si beau, qu\'il est comique et laid !\r\nL\'un agace son bec avec un brûle-gueule,\r\nL\'autre mime, en boitant, l\'infirme qui volait !\r\n\r\nLe Poète est semblable au prince des nuées\r\nQui hante la tempête et se rit de l\'archer ;\r\nExilé sur le sol au milieu des huées,\r\nSes ailes de géant l\'empêchent de marcher.', 1),
(65, 'Baudelaire', 'L’invitation au voyage', '1857-08-23', 'L\'une des meilleures activités sur cette terre.', 'Mon enfant, ma sœur,\r\nSonge à la douceur\r\nD’aller là-bas vivre ensemble !\r\nAimer à loisir,\r\nAimer et mourir\r\nAu pays qui te ressemble !\r\nLes soleils mouillés\r\nDe ces ciels brouillés\r\nPour mon esprit ont les charmes\r\nSi mystérieux\r\nDe tes traîtres yeux,\r\nBrillant à travers leurs larmes.\r\n\r\nLà, tout n’est qu’ordre et beauté,\r\nLuxe, calme et volupté.\r\n\r\nDes meubles luisants,\r\nPolis par les ans,\r\nDécoreraient notre chambre ;\r\nLes plus rares fleurs\r\nMêlant leurs odeurs\r\nAux vagues senteurs de l’ambre,\r\nLes riches plafonds,\r\nLes miroirs profonds,\r\nLa splendeur orientale,\r\nTout y parlerait\r\nÀ l’âme en secret\r\nSa douce langue natale.\r\n\r\nLà, tout n’est qu’ordre et beauté,\r\nLuxe, calme et volupté.\r\n\r\nVois sur ces canaux\r\nDormir ces vaisseaux\r\nDont l’humeur est vagabonde ;\r\nC’est pour assouvir\r\nTon moindre désir\r\nQu’ils viennent du bout du monde.\r\n– Les soleils couchants\r\nRevêtent les champs,\r\nLes canaux, la ville entière,\r\nD’hyacinthe et d’or ;\r\nLe monde s’endort\r\nDans une chaude lumière.\r\n\r\nLà, tout n’est qu’ordre et beauté,\r\nLuxe, calme et volupté.', 1),
(66, 'Voltaire', 'Boldmind et Médroso', '1728-11-12', 'Sur la Liberté de penser.', 'Vers l’an 1707, temps où les Anglais gagnèrent la bataille de Saragosse, protégèrent le Portugal et donnèrent pour quelque temps un roi à l’Espagne, milord Boldmind, officier général, qui avait été blessé, était aux eaux de Barèges. Il y rencontra le comte Médroso, qui, étant tombé de cheval derrière le bagage, à une lieue et demie du champ de bataille, venait prendre les eaux aussi. Il était familier de l’inquisition ; milord Boldmind n’était familier que dans la conversation : un jour, après boire, il eut avec Médroso cet entretien :\r\n\r\n\r\nBOLDMIND. — Vous êtes donc sergent des dominicains ? vous faites là un vilain métier.\r\n\r\n\r\nMÉDROSO. — Il est vrai ; mais j’ai mieux aimé être leur valet que leur victime, et j’ai préféré le malheur de brûler mon prochain à celui d’être cuit moi-même.\r\n\r\n\r\nBOLDMIND. — Quelle horrible alternative ! vous étiez cent fois plus heureux sous le joug des Maures, qui vous laissaient croupir librement dans toutes vos superstitions, et qui, tout vainqueurs qu’ils étaient, ne s’arrogeaient pas le droit inouï de tenir les âmes dans les fers.\r\n\r\n\r\nMÉDROSO. — Que voulez-vous ! il ne nous est permis ni d’écrire, ni de parler, ni même de penser. Si nous parlons, il est aisé d’interpréter nos paroles, encore plus nos écrits. Enfin, comme on ne peut nous condamner dans un auto-da-fé pour nos pensées secrètes, on nous menace d’être brûlés éternellement par l’ordre de Dieu même, si nous ne pensons pas comme les jacobins. Ils ont persuadé au gouvernement que si nous avions le sens commun, tout l’État serait en combustion, et que la nation deviendrait la plus malheureuse de la terre.\r\n\r\n\r\nBOLDMIND. — Trouvez-vous que nous soyons si malheureux, nous autres Anglais qui couvrons les mers de vaisseaux, et qui venons gagner pour vous des batailles au bout de l’Europe ? Voyez-vous que les Hollandais, qui vous ont ravi presque toutes vos découvertes dans l’Inde, et qui aujourd’hui sont au rang de vos protecteurs, soient maudits de Dieu pour avoir donné une entière liberté à la presse, et pour faire le commerce des pensées des hommes ? L’empire romain en a-t-il été moins puissant parce que Tullius Cicero a écrit avec liberté ?\r\n\r\n\r\nMÉDROSO. — Quel est ce Tullius Cicero ? Jamais je n’ai entendu prononcer ce nom-là à la Sainte-Hermandad.\r\n\r\n\r\nBOLDMIND. — C’était un bachelier de l’université de Rome, qui écrivait ce qu’il pensait, ainsi que Julius César, Marcus Aurelius, Titus Lucretius Carus, Plinius, Seneca, et autres docteurs.\r\n\r\n\r\nMÉDROSO. — Je ne les connais point ; mais on m’a dit que la religion catholique, basque et romaine est perdue, si on se met à penser.\r\n\r\n\r\nBOLDMIND. — Ce n’est pas à vous à le croire ; car vous êtes sûr que votre religion est divine, et que les portes d’enfer ne peuvent prévaloir contre elle. Si cela est, rien ne pourra jamais la détruire.\r\n\r\n\r\nMÉDROSO. — Non, mais on peut la réduire à peu de chose ; et c’est pour avoir pensé, que la Suède, le Danemark, toute votre île, la moitié de l’Allemagne, gémissent dans le malheur épouvantable de n’être plus sujets du pape. On dit même que si les hommes continuent à suivre leurs fausses lumières, ils s’en tiendront bientôt à l’adoration simple de Dieu et à la vertu. Si les portes de l’enfer prévalent jamais jusque-là, que deviendra le saint-office ?\r\n\r\n\r\nBOLDMIND. — Si les premiers chrétiens n’avaient pas eu la liberté de penser, n’est-il pas vrai qu’il n’y eût point eu de christianisme ?\r\n\r\n\r\nMÉDROSO. — Que voulez-vous dire ? Je ne vous entends point.\r\n\r\n\r\nBOLDMIND. — Je le crois bien. Je veux dire que si Tibère et les premiers empereurs avaient eu des jacobins qui eussent empêché les premiers chrétiens d’avoir des plumes et de l’encre ; s’il n’avait pas été longtemps permis dans l’empire romain de penser librement, il eût été impossible que les chrétiens établissent leurs dogmes. Si donc le christianisme ne s’est formé que par la liberté de penser, par quelle contradiction, par quelle injustice voudrait-il anéantir aujourd’hui cette liberté sur laquelle seule il est fondé ?\r\n\r\nQuand on vous propose quelque affaire d’intérêt, n’examinez-vous pas longtemps avant de conclure ? Quel plus grand intérêt y a-t-il au monde que celui de notre bonheur ou de notre malheur éternel ? Il y a cent religions sur la terre, qui toutes vous damnent si vous croyez à vos dogmes, qu’elles appellent absurdes et impies ; examinez donc ces dogmes.\r\n\r\n\r\nMÉDROSO. — Comment puis-je les examiner ? je ne suis pas jacobin.\r\n\r\n\r\nBOLDMIND. — Vous êtes homme, et cela suffit.\r\n\r\n\r\nMÉDROSO. — Hélas ! vous êtes bien plus homme que moi.\r\n\r\n\r\nBOLDMIND. — Il ne tient qu’à vous d’apprendre à penser ; vous êtes né avec de l’esprit ; vous êtes un oiseau dans la cage de l’inquisition ; le saint-office vous a rogné les ailes, mais elles peuvent revenir. Celui qui ne sait pas la géométrie peut l’apprendre : tout homme peut s’instruire : il est honteux de mettre son âme entre les mains de ceux à qui vous ne confieriez pas votre argent ; osez penser par vous-même.\r\n\r\n\r\nMÉDROSO. — On dit que si tout le monde pensait par soi-même, ce serait une étrange confusion.\r\n\r\n\r\nBOLDMIND. — C’est tout le contraire. Quand on assiste à un spectacle, chacun en dit librement son avis, et la paix n’est point troublée ; mais si quelque protecteur insolent d’un mauvais poète voulait forcer tous les gens de goût à trouver bon ce qui leur paraît mauvais, alors les sifflets se feraient entendre, et les deux partis pourraient se jeter des pommes à la tête, comme il arriva une fois à Londres. Ce sont ces tyrans des esprits qui ont causé une partie des malheurs du monde. Nous ne sommes heureux en Angleterre que depuis que chacun jouit librement du droit de dire son avis.\r\n\r\n\r\nMÉDROSO. — Nous sommes aussi fort tranquilles à Lisbonne, où personne ne peut dire le sien.\r\n\r\n\r\nBOLDMIND. — Vous êtes tranquilles, mais vous n’êtes pas heureux ; c’est la tranquillité des galériens, qui rament en cadence et en silence.\r\n\r\n\r\nMÉDROSO. — Vous croyez donc que mon âme est aux galères ?\r\n\r\n\r\nBOLDMIND. — Oui ; et je voudrais la délivrer.\r\n\r\n\r\nMÉDROSO. — Mais si je me trouve bien aux galères ?\r\n\r\n\r\nBOLDMIND. — En ce cas vous méritez d’y être. ', 1),
(67, 'Camus', 'L\'Etranger', '1942-11-12', 'Aujourd’hui, ...', 'Aujourd’hui, maman est morte. Ou peut-être hier, je ne sais pas. J’ai reçu un télégramme de l’asile: «Mère décédée. Enterrement demain. Sentiments distingués.» Cela ne veut rien dire. C’était peut-être hier. L’asile de vieillards est à Marengo, à quatre-vingts kilomètres d’Alger. Je prendrai l’autobus à deux heures et j’arriverai dans l’après-midi. Ainsi, je pourrai veiller et je rentrerai demain soir. J’ai demandé deux jours de congé à mon patron et il ne pouvait pas me les refuser avec une excuse pareille. Mais il n’avait pas l’air content. Je lui ai même dit : « Ce n’est pas de ma faute. » II n’a pas répondu. J’ai pensé alors que je n’aurais pas dû lui dire cela. En somme, je n’avais pas à m’excuser. C’était plutôt à lui de me présenter ses condoléances. Mais il le fera sans doute après-demain, quand il me verra en deuil. Pour le moment, c’est un peu comme si maman n’était pas morte. Après l’enterrement, au contraire, ce sera une affaire classée et tout aura revêtu une allure plus officielle.\r\n\r\nJ’ai pris l’autobus à deux heures. II faisait très chaud. J’ai mangé au restaurant, chez Céleste, comme d’habitude. Ils avaient tous beaucoup de peine pour moi et Céleste m’a dit: « On n’a qu’une mère ». Quand je suis parti, ils m’ont accompagné à la porte. J’étais un peu étourdi parce qu’il a fallu que je monte chez Emmanuel pour lui emprunter une cravate noire et un brassard. Il a perdu son oncle, il y a quelques mois.  J’ai couru pour ne pas manquer le départ. Cette hâte, cette course, c’est à cause de tout cela sans doute, ajouté aux cahots, à l’odeur d’essence, à la réverbération de la route et du ciel, que je me suis assoupi. J’ai dormi pendant presque tout le trajet. Et quand je me suis réveillé, j’étais tassé contre un militaire qui m’a souri et qui m’a demandé si je venais de loin. J’ai dit « oui » pour n’avoir plus à parler.', 1),
(68, 'Kant', 'Qu\'est ce que les lumières ?', '2021-04-07', 'Sapere Aude !', 'Les «Lumières» se définissent comme la sortie de l\'homme hors de l\'état de \r\ntutelle  dont il  est  lui-même  responsable.    L\'état  de  tutelle est  l\'incapacité de  se \r\nservir  de  son  entendement  sans être  dirigé  par  un  autre.    Elle  est  due  à  notre \r\npropre  faute  lorsqu\'elle  résulte  non  pas  d\'une  insuffisance  de  l\'entendement, \r\nmais d\'un  manque  de  résolution  et  de  courage  pour  s\'en  servir sans être  dirigé \r\npar  un  autre.   Sapere  aude!   Aie le  courage  de  te  servir  de ton  propre \r\nentendement!  Telle est la devise des Lumières.\r\nParesse  et  lâcheté  sont  les  causes  qui  expliquent  qu\'un  si  grand  nombre \r\nd\'hommes, alors que la nature  les a  affranchis depuis longtemps de toute tutelle \r\nétrangère (naturaliter maiorennes)2, restent cependant volontiers, leur vie \r\ndurant, mineurs; et qu\'il  soit si  facile à d\'autres de les diriger.  Il est si  commode \r\nd\'être  mineur.    Si  j\'ai  un  livre  pour  me  tenir  lieu  d\'entendement,  un  directeur \r\npour  ma  conscience,  un  médecin  pour  mon  régime...  je  n\'ai  pas  besoin  de  me \r\nfatiguer moi-même.   Je  n\'ai  pas besoin de  penser,  pourvu  que  je  puisse  payer; \r\nd\'autres  se  chargeront  à  ma  place  de  ce  travail  fastidieux.   Et  si  la  plupart des \r\nhommes  (et  parmi  eux  le  sexe  faible  en  entier)  finit  par  considérer  comme \r\ndangereux le pas - en soi pénible - qui conduit  à  la majorité,  c\'est  que \r\ns\'emploient à une telle conception leurs bienveillants tuteurs, ceux-là mêmes qui \r\nse  chargent de  les surveiller.   Après avoir rendu stupide le bétail  domestique  et \r\nsoigneusement  pris  garde  que  ces  paisibles créatures ne  puissent  faire  un  pas \r\nhors du parc où ils les ont  enfermés, ils leur montrent ensuite  le danger qu\'il  y \r\naurait  à  marcher  seuls.    Or  le  danger  n\'est  sans  doute  pas  si  grand,  car  après \r\nquelques  chutes  ils  finiraient bien par  apprendre à  marcher,  mais  de tels \r\naccidents  rendent  timorés  et  font  généralement  reculer  devant  toute  nouvelle \r\ntentative.', 1),
(87, 'bob', 'Modal Web', '2021-11-14', 'Une brève présentation du modal web à l\'X.', 'Aujourd\'hui, le nombre de sites Web approche le milliard alors qu\'il n\'en existait que 57.000.000 en 2004. De plus, ces sites proposent de plus en plus de services personnalisés suivant l\'utilisateur : agrégateurs, espaces de travail partagé, sites communautaires ou encore blogs en sont des parfaits exemples. Cette nouvelle donne a vu se développer en parallèle des technologies adaptées pour le développement de tels sites ou devrait-on dire actuellement de telles applications.\r\n\r\nCe cours a pour objectif d\'aborder d\'un point de vue pratique les problèmes liés au développement de ces applications. Les techniques abordées seront les suivantes :\r\n\r\n    Programmation objet en PHP.\r\n    Introduction aux bases de données à travers MySQL.\r\n    Sécurité des applications, cartes et géolocalisation, javascript, Ajax…\r\n\r\nCe cours sera en majeure partie composé de TDs en salle machines, les élèves devant réaliser à terme un projet comme le développement d\'une application Web permettant la gestion dynamique d\'une bibliothèque (clients, stock, réservations, emprunts, rendus, etc.), un petit site d\'hébergement de blogs, de binet, un site collaboratif ou tout autre application du même genre au choix…\r\n\r\nLes TDs seront en plus l\'occasion de découvrir par la pratique quelques notions-clé de l\'informatique contemporaine, couramment employées dans le monde industriel.', 0),
(91, 'alice', 'What just is, isn\'t always just-ice', '2021-01-20', 'Salut à tous. Je partage ce texte d\'Amanda Gorman, prononcé à l\'occasion de l\'investiture du Joe Biden. Il y a plein de questionnements sur l\'avenir des Etats-Unis.', 'When day comes we ask ourselves,\r\nwhere can we find light in this never-ending shade?\r\nThe loss we carry,\r\na sea we must wade\r\nWe\'ve braved the belly of the beast\r\nWe\'ve learned that quiet isn\'t always peace\r\nAnd the norms and notions\r\nof what just is\r\nIsn\'t always just-ice\r\nAnd yet the dawn is ours\r\nbefore we knew it\r\nSomehow we do it\r\nSomehow we\'ve weathered and witnessed\r\na nation that isn\'t broken\r\nbut simply unfinished\r\nWe the successors of a country and a time\r\nWhere a skinny Black girl\r\ndescended from slaves and raised by a single mother\r\ncan dream of becoming president\r\nBut that doesn\'t mean we are\r\nstriving to form a union that is perfect\r\nWe are striving to forge a union with purpose\r\nTo compose a country committed to all cultures, colors, characters and\r\nconditions of man\r\nAnd so we lift our gazes not to what stands between us\r\nbut what stands before us\r\nWe close the divide because we know, to put our future first,\r\nwe must first put our differences aside\r\nWe seek harm to none and harmony for all\r\nLet the globe, if nothing else, say this is true:\r\nThat even as we grieved, we grew\r\nThat even as we hurt, we hoped\r\nThat even as we tired, we tried\r\nThat we\'ll forever be tied together, victorious\r\nNot because we will never again know defeat\r\nbut because we will never again sow division\r\nThen victory won\'t lie in the blade\r\nIt\'s because being American is more than a pride we inherit,\r\nit\'s the past we step into\r\nand how we repair it\r\nWe\'ve seen a force that would shatter our nation\r\nrather than share it\r\nWould destroy our country if it meant delaying democracy\r\nAnd this effort very nearly succeeded\r\nBut while democracy can be periodically delayed\r\nit can never be permanently defeated\r\nIn this truth\r\nin this faith we trust\r\nFor while we have our eyes on the future\r\nhistory has its eyes on us\r\nThis is the era of just redemption\r\nWe feared at its inception\r\nWe did not feel prepared to be the heirs\r\nof such a terrifying hour\r\nbut within it we found the power\r\nto author a new chapter\r\nTo offer hope and laughter to ourselves\r\nWe will not march back to what was\r\nbut move to what shall be\r\nA country that is bruised but whole,\r\nbenevolent but bold,\r\nfierce and free\r\nWe will not be turned around\r\nor interrupted by intimidation\r\nbecause we know our inaction and inertia\r\nwill be the inheritance of the next generation\r\nOur blunders become their burdens\r\nBut one thing is certain:\r\nIf we merge mercy with might,\r\nand might with right,\r\nthen love becomes our legacy\r\nand change our children\'s birth-right\r\nSo let us leave behind a country\r\nbetter than the one we were left with\r\nwe will raise this wounded world into a wondrous one\r\nWe will rise from the gold-limbed hills of the west,\r\nwe will rise from the windswept northeast\r\nwhere our forefathers first realized revolution\r\nWe will rise from the lake-rimmed cities of the midwestern states,\r\nwe will rise from the sunbaked south\r\nWe will rebuild, reconcile and recover\r\nWhen day comes we step out of the shade,\r\naflame and unafraid\r\nThe new dawn blooms as we free it\r\nFor there is always light,\r\nif only we\'re brave enough to see it\r\nIf only we\'re brave enough to be it', 1);

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `id` int(11) NOT NULL,
  `id_texte` int(11) NOT NULL,
  `title` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`id`, `id_texte`, `title`) VALUES
(41, 64, 'Général'),
(42, 65, 'Général'),
(43, 66, 'Général'),
(44, 67, 'Général'),
(45, 64, 'Quid de nos amis poilus ?'),
(46, 68, 'Général'),
(63, 67, 'Au sujet de l\'entropie morale'),
(69, 68, 'Le libre arbitre existe-il ?'),
(75, 87, 'Général'),
(79, 91, 'Général'),
(85, 91, 'Quid des présidentielles de 2022 ?');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `pseudo` varchar(30) NOT NULL,
  `mdp` varchar(500) NOT NULL,
  `promo` int(4) DEFAULT NULL,
  `admin` int(1) NOT NULL DEFAULT 3
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`pseudo`, `mdp`, `promo`, `admin`) VALUES
('alice', '$2y$10$paygHTV9JKaGEJUmKCud7Ogx65QseIMWGWt615ayGiQeVPeBHt/vS', 2020, 1),
('Baudelaire', '$2y$10$XjjA4.nvSuEcyIdSePcpSeALA0SL59gN4cTCWKgzjQjCXfrJKbDFe', 2020, 2),
('Benjamin', '$2y$10$duQ7XN9aRnIX01MAe1I2Pey4diJADOQfj7VWLu11JQ1ml9O.RQ2NK', 2020, 1),
('bob', '$2y$10$zE0tKBtMXkmydV7sx7VEfemF4ZoqrQtFcl7pUUx4qvw79Ujv8Ia9C', 2020, 2),
('Camus', '$2y$10$QjaJF2BKZRZseY/lsaxKRu7XxmKGQzYYRQxRxlLMByiANra1PUYZq', 2021, 2),
('Emile', '$2y$10$hQfs3TMVIb.blwedepK.lu5Pl6/c5BpCAImWSnlsPre33q7X0fxwi', 2020, 1),
('Kant', '$2y$10$EclUeeaoMaEuIMyQ4CfPeubRXbDiSkxWYjnE0pOMau5SxQsrj8jxW', 2019, 2),
('Voltaire', '$2y$10$IYsID22aobdyDW8tf9VUpOYTDYIPQWxZOXIkmUxgjnMCg40Y9qv9i', 2020, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `commentaires`
--
ALTER TABLE `commentaires`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_topic` (`id_topic`),
  ADD KEY `commentaire_pointe_vers_utilisateur` (`pseudo`);

--
-- Indexes for table `textes`
--
ALTER TABLE `textes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pseudo` (`pseudo`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_texte` (`id_texte`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`pseudo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `commentaires`
--
ALTER TABLE `commentaires`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- AUTO_INCREMENT for table `textes`
--
ALTER TABLE `textes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `commentaires`
--
ALTER TABLE `commentaires`
  ADD CONSTRAINT `commentaire_pointe_vers_topic` FOREIGN KEY (`id_topic`) REFERENCES `topics` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `commentaire_pointe_vers_utilisateur` FOREIGN KEY (`pseudo`) REFERENCES `users` (`pseudo`) ON DELETE CASCADE;

--
-- Constraints for table `textes`
--
ALTER TABLE `textes`
  ADD CONSTRAINT `textes_ibfk_1` FOREIGN KEY (`pseudo`) REFERENCES `users` (`pseudo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `topics`
--
ALTER TABLE `topics`
  ADD CONSTRAINT `topic_pointe_vers_texte` FOREIGN KEY (`id_texte`) REFERENCES `textes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
