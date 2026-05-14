# CampaignBuilder - Use Cases

**Document ID:** UC-CAMPAIGN-001  
**Module:** ksf_CampaignBuilder  
**Version:** 1.0.0  

---

## 1. Use Case Overview

| Use Case ID | UC-CAMPAIGN-001 |
|-------------|-----------------|
| Use Case Name | Create Marketing Campaign |
| Created By | Marketing Manager |
| Date Created | 2025-01-01 |

### Actors

| Actor | Role Description |
|-------|------------------|
| Marketing Manager | Primary user, creates and manages campaigns |
| Campaign System | Backend component handling business logic |

---

## 2. Detailed Use Cases

### UC-001: Create Campaign

**Description:** Marketing Manager creates a new marketing campaign with basic information.

**Primary Flow:**
1. Marketing Manager accesses CampaignBuilder interface
2. Marketing Manager clicks "Create Campaign"
3. Marketing Manager enters campaign name (required)
4. Marketing Manager enters description (optional)
5. System generates unique campaign ID
6. System sets status to 'draft'
7. System sets createdAt to current timestamp
8. System saves campaign
9. System returns success confirmation

**Alternative Flow A - Empty Name:**
1. Marketing Manager leaves name field empty
2. System displays validation error
3. Use case ends

**Preconditions:**
- User authenticated with Marketing Manager role
- CampaignBuilder module accessible

**Postconditions:**
- New campaign created with draft status
- Campaign appears in campaign list

---

### UC-002: Add Workflow Nodes

**Description:** Marketing Manager adds workflow nodes to configure campaign behavior.

**Primary Flow:**
1. Marketing Manager selects existing campaign
2. Marketing Manager clicks "Edit Workflow"
3. Marketing Manager adds trigger node (entry point)
4. Marketing Manager adds action nodes
5. Marketing Manager connects nodes via outcomes
6. System validates workflow structure
7. System saves campaign with nodes

**Alternative Flow A - Add Outcome:**
1. Marketing Manager selects source node
2. Marketing Manager clicks "Add Outcome"
3. Marketing Manager selects target node
4. Marketing Manager sets condition (optional)
5. System creates CampaignOutcome

**Preconditions:**
- Campaign exists with draft status
- User has edit permissions

**Postconditions:**
- Campaign contains workflow nodes
- Nodes connected via outcomes

---

### UC-003: Activate Campaign

**Description:** Marketing Manager activates a validated campaign for execution.

**Primary Flow:**
1. Marketing Manager selects validated campaign
2. Marketing Manager clicks "Activate"
3. System validates campaign:
   - Name is not empty
   - At least one node exists
   - At least one trigger exists
   - No infinite loops detected
4. If validation passes:
   - System sets isActive to true
   - System sets status to 'active'
   - System saves campaign
   - System returns success
5. If validation fails:
   - System returns list of errors
   - Use case ends

**Alternative Flow A - Validation Fails:**
1. System detects validation error
2. System displays error details
3. Marketing Manager corrects issues
4. Use case returns to step 3

**Preconditions:**
- Campaign exists with draft or paused status
- Campaign has passed validation

**Postconditions:**
- Campaign status set to 'active'
- Campaign isActive() returns true

---

### UC-004: Schedule Campaign

**Description:** Marketing Manager schedules a campaign to activate at a future time.

**Primary Flow:**
1. Marketing Manager selects draft campaign
2. Marketing Manager clicks "Schedule"
3. Marketing Manager selects start date/time
4. Marketing Manager selects end date/time (optional)
5. System validates dates:
   - Start date is in future
   - End date is after start date (if set)
6. System sets startsAt and endsAt
7. System saves campaign

**Preconditions:**
- Campaign exists with draft status
- At least one future time slot available

**Postconditions:**
- Campaign has scheduled dates
- isScheduled() returns true

---

### UC-005: View Campaign Details

**Description:** User views complete campaign information including workflow.

**Primary Flow:**
1. User selects campaign from list
2. User clicks "View Details"
3. System retrieves campaign data
4. System serializes to JSON format
5. System displays campaign details:
   - Basic information
   - Workflow nodes
   - Triggers
   - Status

**Preconditions:**
- Campaign exists

**Postconditions:**
- Campaign data displayed
- No modifications made

---

## 3. Sequence Diagrams

### UC-003: Activate Campaign Sequence

```
┌──────────────┐     ┌───────────────┐     ┌──────────────┐     ┌─────────────┐
│   Marketing   │     │    Campaign   │     │   Campaign   │     │ Repository  │
│    Manager    │     │    Service    │     │    Entity    │     │             │
└──────┬───────┘     └───────┬───────┘     └──────┬───────┘     └──────┬──────┘
       │                    │                      │                    │
       │ activate(campId)  │                      │                    │
       │──────────────────>│                      │                    │
       │                    │                      │                    │
       │                    │ findById(campId)     │                    │
       │                    │─────────────────────>                    │
       │                    │                      │                    │
       │                    │                      │    SELECT * FROM   │
       │                    │                      │    fa_campaign     │
       │                    │                      │───────────────────>│
       │                    │                      │                    │
       │                    │    return Campaign   │                    │
       │                    │<─────────────────────                    │
       │                    │                      │                    │
       │                    │    validate()        │                    │
       │                    │─────────────────────>                    │
       │                    │                      │                    │
       │                    │    errors[]         │                    │
       │                    │<─────────────────────                    │
       │                    │                      │                    │
       │                    │    activate()        │                    │
       │                    │─────────────────────>                    │
       │                    │                      │                    │
       │                    │    save()            │                    │
       │                    │─────────────────────>                    │
       │                    │                      │                    │
       │    success        │                      │                    │
       │<───────────────────│                      │                    │
       │                    │                      │                    │
```