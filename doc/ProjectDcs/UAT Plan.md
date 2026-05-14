# CampaignBuilder - UAT Plan

**Document ID:** UAT-CAMPAIGN-001  
**Module:** ksf_CampaignBuilder  
**Version:** 1.0.0  

---

## 1. UAT Objectives

The User Acceptance Testing for CampaignBuilder will verify that:

1. Marketing managers can successfully create and manage campaigns
2. Workflow nodes function as designed
3. Campaign validation catches invalid configurations
4. System integrates correctly with dependent modules

## 2. Test Scenarios

### 2.1 Campaign Creation

| Scenario ID | Scenario | Expected Result | Tester Actions |
|-------------|----------|-----------------|----------------|
| UAT-001 | Create campaign with valid name | Campaign created in draft status | Enter name → Submit → Verify status |
| UAT-002 | Create campaign with description | Description stored correctly | Add description → Save → View details |
| UAT-003 | Create campaign without name | Error displayed | Submit without name → Verify error message |

### 2.2 Workflow Configuration

| Scenario ID | Scenario | Expected Result | Tester Actions |
|-------------|----------|-----------------|----------------|
| UAT-010 | Add trigger node to campaign | Trigger appears in workflow | Add trigger → Verify in node list |
| UAT-011 | Add multiple action nodes | All nodes appear | Add 3 nodes → Verify count |
| UAT-012 | Connect nodes with outcomes | Connection saved | Select source → Select target → Save |
| UAT-013 | Remove node from workflow | Node removed, connections updated | Remove node → Verify removal |

### 2.3 Campaign Activation

| Scenario ID | Scenario | Expected Result | Tester Actions |
|-------------|----------|-----------------|----------------|
| UAT-020 | Activate valid campaign | Status changes to active | Click activate → Verify status |
| UAT-021 | Activate campaign without nodes | Error displayed | Attempt activate → Verify error |
| UAT-022 | Activate campaign without triggers | Error displayed | Attempt activate → Verify error |
| UAT-023 | Activate campaign with cycle | Error displayed | Create loop → Attempt activate |

### 2.4 Campaign Scheduling

| Scenario ID | Scenario | Expected Result | Tester Actions |
|-------------|----------|-----------------|----------------|
| UAT-030 | Schedule campaign with future date | isScheduled returns true | Set date → Verify status |
| UAT-031 | Schedule campaign with past date | Error or warning | Set past date → Verify handling |
| UAT-032 | Set campaign end date before start | Error displayed | Set invalid dates → Verify error |

### 2.5 Campaign Data Management

| Scenario ID | Scenario | Expected Result | Tester Actions |
|-------------|----------|-----------------|----------------|
| UAT-040 | View campaign details | All data displayed correctly | View campaign → Verify all fields |
| UAT-041 | Export campaign to JSON | Valid JSON downloaded | Click export → Verify JSON |
| UAT-042 | Clone existing campaign | New draft created | Clone campaign → Verify new draft |

## 3. UAT Test Data

### 3.1 Test Users

| User | Role | Permissions |
|------|------|-------------|
| test_marketing_mgr | Marketing Manager | Full CRUD |
| test_marketing_analyst | Marketing Analyst | Read-only |

### 3.2 Test Campaigns

| Campaign ID | Name | Status | Purpose |
|-------------|------|--------|---------|
| TEST-001 | UAT Test Campaign 1 | draft | Node addition testing |
| TEST-002 | UAT Test Campaign 2 | draft | Validation testing |
| TEST-003 | UAT Test Campaign 3 | active | Activation testing |

## 4. Sign-Off Criteria

| Criterion | Requirement | Verified By |
|-----------|-------------|-------------|
| Campaign CRUD | All basic operations work | Marketing Manager |
| Workflow Nodes | Nodes add, remove, connect correctly | Marketing Manager |
| Validation | All invalid cases caught | QA Lead |
| Integration | Works with CRM module | Integration Tester |

## 5. UAT Sign-Off

| Role | Name | Signature | Date |
|------|------|-----------|------|
| Marketing Manager | | | |
| QA Lead | | | |
| Business Analyst | | | |
| Project Manager | | | |

## 6. Defect Reporting

Any defects found during UAT should be documented with:
- Steps to reproduce
- Expected vs actual behavior
- Screenshots
- Severity assessment

Defects will be tracked in the project issue tracker with label "UAT-Defect".