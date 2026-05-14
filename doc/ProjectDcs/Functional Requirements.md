# CampaignBuilder - Functional Requirements

**Document ID:** FR-CAMPAIGN-001  
**Module:** ksf_CampaignBuilder  
**Version:** 1.0.0  

---

## 1. Introduction

This document specifies the functional requirements for the CampaignBuilder module, defining the detailed behavior and features required for marketing campaign workflow management.

## 2. Requirements Specification

### 2.1 Campaign Entity Management

| ID | Requirement | Priority | Validated By |
|----|-------------|----------|--------------|
| FR-001 | System SHALL allow creation of new campaigns with unique ID, name, and optional description | MUST | CampaignEntityTest::testCreate |
| FR-002 | System SHALL support updating campaign name and description after creation | MUST | CampaignEntityTest::testSetName |
| FR-003 | System SHALL track campaign creation and last modification timestamps | MUST | CampaignEntityTest::testTimestamps |
| FR-004 | System SHALL support scheduling campaigns with start and end dates | MUST | CampaignEntityTest::testScheduling |

### 2.2 Campaign Status Management

| ID | Requirement | Priority | Validated By |
|----|-------------|----------|--------------|
| FR-010 | System SHALL support campaign statuses: draft, active, paused, completed | MUST | CampaignEntityTest::testStatus |
| FR-011 | System SHALL allow activating a campaign when validation passes | MUST | CampaignEntityTest::testActivation |
| FR-012 | System SHALL allow deactivating an active campaign | MUST | CampaignEntityTest::testDeactivation |
| FR-013 | System SHALL report isActive() as true only when both isActive flag and status are set | MUST | CampaignEntityTest::testIsActive |

### 2.3 Workflow Node Management

| ID | Requirement | Priority | Validated By |
|----|-------------|----------|--------------|
| FR-020 | System SHALL support adding nodes to a campaign | MUST | CampaignEntityTest::testAddNode |
| FR-021 | System SHALL support removing nodes from a campaign | MUST | CampaignEntityTest::testRemoveNode |
| FR-022 | System SHALL allow retrieval of all nodes in a campaign | MUST | CampaignEntityTest::testGetNodes |
| FR-023 | System SHALL allow retrieval of a specific node by ID | MUST | CampaignEntityTest::testGetNode |
| FR-024 | System SHALL report accurate node count for a campaign | MUST | CampaignEntityTest::testNodeCount |

### 2.4 Trigger Management

| ID | Requirement | Priority | Validated By |
|----|-------------|----------|--------------|
| FR-030 | System SHALL support adding triggers to a campaign | MUST | CampaignEntityTest::testAddTrigger |
| FR-031 | System SHALL allow retrieval of all triggers for a campaign | MUST | CampaignEntityTest::testGetTriggers |
| FR-032 | System SHALL indicate whether campaign has valid triggers | MUST | CampaignEntityTest::testHasTriggers |

### 2.5 Campaign Validation

| ID | Requirement | Priority | Validated By |
|----|-------------|----------|--------------|
| FR-040 | System SHALL validate that campaign name is not empty | MUST | CampaignEntityTest::testValidateName |
| FR-041 | System SHALL validate that at least one workflow node exists | MUST | CampaignEntityTest::testValidateNodes |
| FR-042 | System SHALL validate that at least one trigger exists | MUST | CampaignEntityTest::testValidateTriggers |
| FR-043 | System SHALL detect cycles/infinite loops in workflow graph | MUST | CampaignEntityTest::testCycleDetection |
| FR-044 | System SHALL return all validation errors (not just first) | MUST | CampaignEntityTest::testValidateAll |

### 2.6 Serialization

| ID | Requirement | Priority | Validated By |
|----|-------------|----------|--------------|
| FR-050 | System SHALL serialize campaign to JSON format | MUST | CampaignEntityTest::testJsonSerialize |
| FR-051 | System SHALL deserialize campaign from array data | MUST | CampaignEntityTest::testFromArray |
| FR-052 | JSON output SHALL include all nodes and triggers | MUST | CampaignEntityTest::testJsonIncludesNested |

## 3. Data Flow

```
User Input → CampaignService → Campaign Entity → Validation → Repository → Database
                                       ↓
                               Event Emission
                                       ↓
                               External Systems
```

## 4. Edge Cases

| Scenario | Expected Behavior |
|----------|-------------------|
| Empty campaign name | Validation returns error |
| No nodes added | Validation returns error |
| Cycle exists in workflow | Validation returns error, hasCycle() returns true |
| Setting future start date | isScheduled() returns true |
| End date in past | isExpired() returns true |
| Deactivating active campaign | Status set to 'paused' |