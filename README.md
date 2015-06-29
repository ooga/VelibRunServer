# VelibRun
Rest API running on Symfony 2 used by Android GPS tracking app, in order to make runs on Paris using Velibs.

Apis
------------

### Races
Get all
```/GET /races```

Get specific race
```/GET /races/<id>```

Create race
```/POST /races```

| parameters |
|------------|
| name       |

### Users
Get all
```/GET /races/<id_race>/users```

Get specific user
```/GET /races/<id_race>/users/<id>```

Create user
```/POST /races/<id_race>/users```

| parameters |
|------------|
| uiid       |
| name       |

### Checkpoints
Get all
```/GET /races/<id_race>/checkpoints```

Get specific checkpoint
```/GET /races/<id_race>/checkpoints/<id>```

Create checkpoint
```/POST /races/<id_race>/checkpoints```

| parameters |
|------------|
| uiid       |
| lat        |
| lon        |
| alt        |
| accur      |
| speed      |

Android GPS tracking app
------------------------
[VelibRun] (https://github.com/VincentCATILLON/VelibRun) 

Contributors
------------
- [Stanley Blaise] (https://github.com/stanosz) 
- [Johan Rouve] (https://github.com/ooga)
- [Vincent Catillon] (https://github.com/VincentCATILLON)
