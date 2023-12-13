--create database 
IF NOT EXISTS (SELECT name FROM master.dbo.sysdatabases WHERE name = 'toDoApp') CREATE DATABASE toDoApp;
--create users table 
IF NOT EXISTS (SELECT * FROM sysobjects WHERE name='users' AND xtype='U') 
        CREATE TABLE users (
            usersId INT PRIMARY KEY IDENTITY(1,1),
            usersName VARCHAR(200) NOT NULL,
            usersPass VARCHAR(200) NOT NULL,
			usersUid VARCHAR(200) NOT NULL,
			usersEmail VARCHAR(200) NOT NULL,

        );
--create tasks table 
IF NOT EXISTS (SELECT * FROM sysobjects WHERE name='task' AND xtype='U') 
        CREATE TABLE task (
            id INT PRIMARY KEY IDENTITY(1,1),
            title VARCHAR(200) NOT NULL,
            status TINYINT DEFAULT 0,
			usersId INT ,
			constraint fk_ut foreign key(usersId)
			references users(usersId)
        );
-- Create a stored procedure to insert task's title
CREATE PROCEDURE InsertTask
    @title NVARCHAR(255),
    @usersId INT
AS
BEGIN
    INSERT INTO task (title, usersId)
    VALUES (@title, @usersId);
END
-- Create a stored procedure to update a task's title
CREATE PROCEDURE UpdateTaskTitle
    @title NVARCHAR(255),
    @taskId INT
AS
BEGIN
    UPDATE [task]
    SET [title] = @title
    WHERE [id] = @taskId;
END;
GO
-- Create a stored procedure to update task's status
CREATE PROCEDURE UpdateTaskStatus
    @taskId INT,
    @currentStatus INT
AS
BEGIN
    UPDATE [task]
    SET [status] = @currentStatus
    WHERE [id] = @taskId;
END

-- Create a stored procedure to get the tasks by id     
CREATE PROCEDURE GetTaskById
    @taskId INT
AS
BEGIN
    SELECT *
    FROM [task]
    WHERE [id] = @taskId;
END
-- Create a stored procedure to delete task
CREATE PROCEDURE DeleteTaskById
    @taskId INT
AS
BEGIN
    DELETE FROM [task]
    WHERE [id] = @taskId;
END
-- function count the tasks that the user add 
CREATE FUNCTION GetTaskCountForUser(@userId INT)
RETURNS INT
AS
BEGIN
    DECLARE @count INT;

    SELECT @count = COUNT(*)
    FROM [task]
    WHERE [usersId] = @userId;

    RETURN @count;
END

CREATE TABLE TaskLog (
    LogID INT PRIMARY KEY IDENTITY(1,1),
    TaskTitle NVARCHAR(100),
    UserID INT,
    ActionPerformed NVARCHAR(100),
    Timestamp DATETIME
);

--trigger that insert time of insert the task 
CREATE TRIGGER Task_Insert_Log
ON [task]
AFTER INSERT
AS
BEGIN
    DECLARE @TaskTitle NVARCHAR(100)
    DECLARE @UserID INT

    SELECT @TaskTitle = inserted.title, @UserID = inserted.usersId
    FROM inserted

    -- Log the newly added task into a log table
    INSERT INTO TaskLog (TaskTitle, UserID, ActionPerformed, Timestamp)
    VALUES (@TaskTitle, @UserID, 'Task Added', GETDATE())
END


alter table task add time datetime ;


CREATE TRIGGER Tasks_Insert_Time
ON [task]
AFTER INSERT
AS
BEGIN
    DECLARE @TaskTitle NVARCHAR(100)
    DECLARE @UserID INT

    SELECT @TaskTitle = inserted.title, @UserID = inserted.usersId
    FROM inserted

    -- Update the 'time' column with the current timestamp
    UPDATE [task]
    SET time = GETDATE()
    WHERE title = @TaskTitle AND usersId = @UserID
END


CREATE PROCEDURE GetDoneTaskCount
    @userId INT
AS
BEGIN
    SELECT COUNT(*) AS DoneTaskCount
    FROM [task]
    WHERE [usersId] = @userId AND [status] = 1;
END




