# CampaignBuilder - Test Plan

**Document ID:** TP-CAMPAIGN-001  
**Module:** ksf_CampaignBuilder  
**Version:** 1.0.0  

---

## 1. Test Scope

### 1.1 Test Objectives

- Verify Campaign entity creation and manipulation
- Validate workflow cycle detection
- Ensure serialization/deserialization correctness
- Confirm node and trigger management

### 1.2 Test Items

| Item | Description |
|------|-------------|
| Campaign Entity | Core business entity for campaigns |
| CampaignNode Entity | Workflow node representation |
| CampaignOutcome Entity | Node connection representation |
| CampaignTrigger Entity | Campaign entry point triggers |

## 2. Test Matrix

### 2.1 Campaign Entity Tests

| Test ID | Test Name | Test Data | Pass Criteria |
|---------|-----------|-----------|---------------|
| TC-001 | testCreate | name="Test Campaign" | Campaign created with correct ID and name |
| TC-002 | testSetName | name="Updated Name" | Name updated, returns correct value |
| TC-003 | testSetDescription | description="Test desc" | Description updated correctly |
| TC-004 | testStatus | status="active" | Status set and retrievable |
| TC-005 | testActivation | draft campaign | Status becomes 'active', isActive true |
| TC-006 | testDeactivation | active campaign | Status becomes 'paused', isActive false |
| TC-007 | testIsActive | active=true, status='active' | isActive() returns true |
| TC-008 | testIsActive_False | active=false | isActive() returns false |
| TC-009 | testTimestamps | created campaign | createdAt set, updatedAt initially null |

### 2.2 Node Management Tests

| Test ID | Test Name | Test Data | Pass Criteria |
|---------|-----------|-----------|---------------|
| TC-010 | testAddNode | CampaignNode array | Node added, count increases |
| TC-011 | testRemoveNode | nodeId | Node removed, count decreases |
| TC-012 | testGetNodes | multiple nodes | Returns array of all nodes |
| TC-013 | testGetNode | existing nodeId | Returns correct node |
| TC-014 | testGetNode_NotFound | invalid nodeId | Returns null |
| TC-015 | testHasNode | existing nodeId | hasNode() returns true |
| TC-016 | testNodeCount | 3 nodes added | getNodeCount() returns 3 |

### 2.3 Trigger Management Tests

| Test ID | Test Name | Test Data | Pass Criteria |
|---------|-----------|-----------|---------------|
| TC-020 | testAddTrigger | CampaignTrigger | Trigger added successfully |
| TC-021 | testGetTriggers | multiple triggers | Returns array of triggers |
| TC-022 | testHasTriggers | with triggers | hasTriggers() returns true |
| TC-023 | testHasTriggers_Empty | no triggers | hasTriggers() returns false |

### 2.4 Validation Tests

| Test ID | Test Name | Test Data | Pass Criteria |
|---------|-----------|-----------|---------------|
| TC-030 | testValidateName | name="" | Error "Campaign name is required" |
| TC-031 | testValidateNodes | empty nodes[] | Error "At least one workflow node is required" |
| TC-032 | testValidateTriggers | no triggers | Error "At least one trigger is required" |
| TC-033 | testValidateAll | multiple issues | Returns array with all errors |
| TC-034 | testCycleDetection | infinite loop graph | hasCycle() returns true |
| TC-035 | testCycleDetection_Valid | valid graph | hasCycle() returns false |

### 2.5 Scheduling Tests

| Test ID | Test Name | Test Data | Pass Criteria |
|---------|-----------|-----------|---------------|
| TC-040 | testScheduling | startsAt in future | isScheduled() returns true |
| TC-041 | testScheduling_Past | startsAt in past | isScheduled() returns false |
| TC-042 | testExpiration | endsAt in past | isExpired() returns true |

### 2.6 Serialization Tests

| Test ID | Test Name | Test Data | Pass Criteria |
|---------|-----------|-----------|---------------|
| TC-050 | testJsonSerialize | complete campaign | Valid JSON with all fields |
| TC-051 | testFromArray | array data | Campaign created from array |
| TC-052 | testJsonIncludesNested | with nodes/triggers | JSON includes nodes array |

## 3. Test Data

### 3.1 Valid Campaign Data

```php
$validCampaignData = [
    'id' => 'camp-001',
    'name' => 'Summer Sale 2025',
    'description' => 'Annual summer promotion campaign',
    'status' => 'draft',
    'is_active' => false,
];
```

### 3.2 Valid Node Data

```php
$validNodeData = [
    'id' => 'node-001',
    'type' => 'email',
    'config' => [
        'template' => 'welcome',
        'subject' => 'Welcome to our campaign',
    ],
];
```

### 3.3 Valid Trigger Data

```php
$validTriggerData = [
    'id' => 'trigger-001',
    'type' => 'form_submission',
    'config' => [
        'form_id' => 1,
    ],
];
```

## 4. Test Environment

| Requirement | Specification |
|-------------|---------------|
| PHP Version | 7.3+ |
| Testing Framework | PHPUnit |
| Database | MySQL/MariaDB (integration tests) |
| OS | Linux |

## 5. Pass Criteria Summary

- All unit tests MUST pass
- Campaign entity MUST serialize to valid JSON
- Cycle detection MUST correctly identify loops
- Validation MUST return all errors, not just first
- 100% code coverage target for entities