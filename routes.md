# Messages

```
GET     /messages
PUT     /messages
PATCH   /messages/[uid]
DELETE  /messages/[uid]/delete
```

# Reminders

```
GET   /reminders
POST  /reminders
```

# Appointments

```
GET /appointments/[year]/[month]
GET /appointments/requesting-procedure-access
```

# Timeslots

```
PUT     /timeslots/appointments
DELETE  /timeslots/appointments/[slotSeconds]
PUT     /timeslots/closed
DELETE  /timeslots/closed/[slotSeconds]
GET     /timeslots/unavailable/[year]/[month]
```

# Auth

```
POST /auth/register/admin
POST /auth/register
POST /auth/user/name
```

# Users

```
GET /users/archived/search/by-name/[nameFilter]
GET /users/archived
GET /users/search/by-name/[nameFilter]
GET /users
```

# User profile

```
/users/[patientUid]/index.get.ts
/users/[patientUid]/archived.post.ts
/users/[patientUid]/archived.delete.ts
```

# User Appointments

```
GET     /users/[patientUid]/appointments
PUT     /users/[patientUid]/appointments
POST    /users/[patientUid]/appointments/[slotSeconds]/payment
DELETE  /users/[patientUid]/appointments/[slotSeconds]/cancel
DELETE  /users/[patientUid]/appointments/[slotSeconds]/delete
PUT     /users/[patientUid]/appointments/[slotSeconds]/attended
PATCH   /users/[patientUid]/appointments/[slotSeconds]/attended
DELETE  /users/[patientUid]/appointments/[slotSeconds]/attended
GET     /users/[patientUid]/appointments/[slotSeconds]/procedure
PATCH   /users/[patientUid]/appointments/[slotSeconds]/procedure
PUT     /users/[patientUid]/appointments/[slotSeconds]/procedure/access
DELETE  /users/[patientUid]/appointments/[slotSeconds]/procedure/access
PUT     /users/[patientUid]/appointments/[slotSeconds]/procedure/request-access
DELETE  /users/[patientUid]/appointments/[slotSeconds]/procedure/request-access
```

# User Signatures

```
GET   /users/[patientUid]/signatures/guardian
PATCH /users/[patientUid]/signatures/guardian
GET   /users/[patientUid]/signatures/patient
PATCH /users/[patientUid]/signatures/patient
```

# User Dental charts

```
GET   /users/[patientUid]/charts/medical-chart/filled-in
POST  /users/[patientUid]/charts/medical-chart/filled-in
GET   /users/[patientUid]/charts/medical-chart
PATCH /users/[patientUid]/charts/medical-chart
GET   /users/[patientUid]/charts/dental-chart
PATCH /users/[patientUid]/charts/dental-chart
GET   /users/[patientUid]/charts/deciduous-chart
PATCH /users/[patientUid]/charts/deciduous-chart
```

# User Assessment forms

```
GET   /users/[patientUid]/forms/assessment
PATCH /users/[patientUid]/forms/assessment
GET   /users/[patientUid]/forms/consent
PATCH /users/[patientUid]/forms/consent
```
