commit 8d531341cc99ec09aaaa178611066ab04f87b8ec
Author: Matt Claudio <mattgclaudio@gmail.com>
Date:   Tue Oct 20 10:30:47 2020 -0400

    rabbit server to merge

commit f5e5cef550dd0af46103cd36c7a5ec57dc39d2ad
Author: Matt Claudio <mattgclaudio@gmail.com>
Date:   Tue Oct 13 13:34:03 2020 -0400

    test

commit b348c197aea588bad98e0e473d04e670e38aa112
Author: Matt Claudio <mattgclaudio@gmail.com>
Date:   Mon Oct 12 21:04:07 2020 -0400

    DMZ changes 1

commit c214c7e7dcb0bc7f7c4fe33c4d8b5a338013d8a5
Author: Matt Claudio <mattgclaudio@gmail.com>
Date:   Tue Sep 29 14:18:14 2020 -0400

    Working RabbitVM files, all included

commit 51f9900a734482d6c6f5c6533a3dbdc6fc581cde
Author: Matt Claudio <mattgclaudio@gmail.com>
Date:   Tue Sep 29 04:31:34 2020 -0400

    New files to integrate DB as well as Apache2

commit 2ef646773093531dc99eabd5231ab4242d0fa776
Author: mattgclaudio <mc824@njit.edu>
Date:   Mon Sep 28 03:12:08 2020 -0400

    Update README.md

commit 1640d954143c4415aabcc5c7bc76bda1c868c29d
Author: mattgclaudio <mc824@njit.edu>
Date:   Mon Sep 28 03:11:17 2020 -0400

    Update README.md

commit 77213c8d1b739956baf8a1a26ea34df19db80cd6
Author: mattgclaudio <mc824@njit.edu>
Date:   Mon Sep 28 03:09:53 2020 -0400

    Update loginScript.php

commit 6e6a9fe7c2b05c5dc9df4989ef9657445cc01c21
Author: mattgclaudio <mc824@njit.edu>
Date:   Mon Sep 28 03:07:00 2020 -0400

    Create unifiedServer.php
    
    This server builds upon the addCredsServer.php and has a link to call the loginScript function. That function, loginScript, is held in a separate file as it needs its own .ini file to connect to the RabbitServer on the DB. After it runs and receives a response from the DB, the method returns either true or false, which is passed back to Apache2 and thrown up to the screen.

commit 2249c93b12710df7845494d21c37b797f8c0fd31
Author: mattgclaudio <mc824@njit.edu>
Date:   Sun Sep 27 21:35:26 2020 -0400

    Update and rename unified_server.php.txt to loginScript.php

commit efd78c3bf384785a82f8e631e75f2c40e190b0c6
Author: mattgclaudio <mc824@njit.edu>
Date:   Sun Sep 27 21:20:56 2020 -0400

    Add files via upload

commit 58849d346bb343875a245360f50ca27452ed2452
Author: mattgclaudio <mc824@njit.edu>
Date:   Sun Sep 27 21:08:43 2020 -0400

    Update addCredsServer.php

commit 64413dfbc102daeddbb8e59a8c3627891cc5e26e
Merge: 40f54cb a5943b1
Author: mattgclaudio <mc824@njit.edu>
Date:   Sun Sep 27 21:07:36 2020 -0400

    Merge pull request #1 from smalishuk/patch-1
    
    Update addCredsServer.php

commit a5943b14c7678748727f92991a61e358be8f47c5
Author: smalishuk <55061544+smalishuk@users.noreply.github.com>
Date:   Sun Sep 27 15:01:56 2020 -0400

    Update addCredsServer.php

commit 40f54cb4b1f4085b3793e05bdcd0282f01832cb1
Author: Matt Claudio <mattgclaudio@gmail.com>
Date:   Fri Sep 25 15:29:39 2020 -0400

    Should just be the updated Server Code to take and return the credentials,
    proof of functionality for moving credentials held in PHP vars
    from Apache to the server, then sending something back.

commit dd0f7c89282e27295573d377ab311c42fe92805d
Merge: 98d8be7 12714a1
Author: Matt Claudio <mattgclaudio@gmail.com>
Date:   Fri Sep 25 14:54:35 2020 -0400

    Merge branch 'RabbitVM' of https://github.com/mattgclaudio/IT490 into RabbitVM

commit 12714a180514ac3319da0eee96552fc5499ec677
Author: mattgclaudio <mc824@njit.edu>
Date:   Fri Sep 25 14:52:50 2020 -0400

    Update README.md

commit 98d8be71988e33327756a037f8cf52759ef21b25
Author: Matt Claudio <mattgclaudio@gmail.com>
Date:   Fri Sep 25 14:51:24 2020 -0400

    hopefully just host.ini?

commit 51b165c48867235a45a5f59c988b6c6d90d0b45b
Author: mattgclaudio <mc824@njit.edu>
Date:   Fri Sep 25 14:43:53 2020 -0400

    Update README.md

commit 293e3f9361b7a5616debac36ed17fc00db68fe5f
Author: mattgclaudio <mc824@njit.edu>
Date:   Fri Sep 25 14:34:22 2020 -0400

    Create README.md

commit b7d45294c23b6dd7c6969e981e18eee7be4a9a25
Author: Matt Claudio <mattgclaudio@gmail.com>
Date:   Fri Sep 25 14:29:15 2020 -0400

    Server Code for RabbitVM which works with the uploaded Apache2 code
    in the Stag repo.
