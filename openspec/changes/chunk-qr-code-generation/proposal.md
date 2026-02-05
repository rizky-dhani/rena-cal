# Proposal: Chunk QR Code Generation

This proposal aims to improve the stability and scalability of the "Empty QR Code" generation feature by implementing chunking. Instead of processing up to 1,000 QR codes in a single background job, the work will be divided into smaller, manageable chunks dispatched as separate jobs.

## Problem
The current implementation dispatches a single job for the entire requested batch (up to 1,000 units). This poses several risks:
1. **Timeouts**: Generating 1,000 images and performing disk I/O may exceed the queue worker's timeout (often 60-300 seconds).
2. **Memory Usage**: Processing 1,000 records and their generated binary data in a single loop increases the risk of memory exhaustion.
3. **Lack of Progress Granularity**: If the job fails halfway, none of the records are inserted (due to the bulk insert at the end), and there's no easy way to resume or see partial progress.

## Solution
1. **Action-Level Chunking**: Modify the `ListDevices` action to divide the requested number of QR codes into chunks of 100.
2. **Sequence Pre-calculation**: To avoid race conditions between concurrent chunked jobs, the starting sequence number (`RENA-XXXXX`) will be calculated once in the action and passed to each job with an offset.
3. **Multi-Job Dispatch**: Dispatch multiple `GenerateMultipleQRCodesJob` instances, each handling one chunk.
4. **Job Refactoring**: Update the job to accept a `startNumber`, allowing it to proceed without querying the database for the maximum number.

## Scope
- `app/Filament/Dashboard/Resources/Devices/Pages/ListDevices.php`: Implement chunking and sequence calculation logic.
- `app/Jobs/GenerateMultipleQRCodesJob.php`: Update constructor and handle method to use the provided starting sequence number.
- `tests/Feature/GenerateMultipleQRCodesJobTest.php`: Update tests to reflect the new parameters.
