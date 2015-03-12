CREATE TABLE [#__patchtester_pulls] (
  [id] [bigint] IDENTITY(1,1) NOT NULL,
  [pull_id] [bigint] NOT NULL,
  [title] [nvarchar](100) NOT NULL,
  [description] [nvarchar](4000) NOT NULL DEFAULT '',
  [pull_url] [nvarchar](255) NOT NULL,
 CONSTRAINT [PK_#__patchtester_pulls] PRIMARY KEY CLUSTERED
(
  [id] ASC
) WITH (STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF)
);

CREATE TABLE [#__patchtester_tests](
  [id] [bigint] IDENTITY(1,1) NOT NULL,
  [pull_id] [bigint] NOT NULL,
  [data] [nvarchar](MAX) NULL,
  [patched_by] [bigint] NOT NULL,
  [applied] [bigint] NOT NULL,
  [applied_version] [nvarchar](25) NOT NULL,
  [comments] [nvarchar](255) NOT NULL DEFAULT '',
 CONSTRAINT [PK_#__patchtester_tests] PRIMARY KEY CLUSTERED
(
  [id] ASC
) WITH (STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF)
);
