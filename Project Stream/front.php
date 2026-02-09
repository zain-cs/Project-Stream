<?php
// === PHP INCLUDES AND SETUP ===
include("includes/config.php");
include("includes/chk-session.php");
include('includes/connect.php');
include("includes/top-member.php");
$pageTitle = "Posts by students | Unite For Education";
$mainClass = " fontPage";
include("includes/header.php");
$error = '';
$success = '';

// Handle post deletion
if (isset($_GET['delete']) && isset($_GET['postid'])) {
    $postid = (int)$_GET['postid'];
    $memid = (int)$_SESSION["memid"];

    // Check if user owns the post
    $checkQuery = "SELECT userid FROM tblposts WHERE postid = $postid";
    $checkResult = $link->query($checkQuery);

    if ($checkResult && $checkResult->num_rows > 0) {
        $checkRow = $checkResult->fetch_array(MYSQLI_ASSOC);
        if ($checkRow['userid'] == $memid) {
            $deleteQuery = "DELETE FROM tblposts WHERE postid = $postid";
            if ($link->query($deleteQuery)) {
                $success = "Post deleted successfully!";
            }
        }
    }
}

// Handle post editing - FIXED VERSION
if (isset($_POST["editPost"])) {
    $postid = (int)$_POST["postid"];
    $memid = (int)$_SESSION["memid"];
    $postContent = $link->real_escape_string(trim($_POST["editPostContent"]));

    if (empty($postContent)) {
        $error = "Post content cannot be empty!";
    } else {
        // Check if user owns the post
        $checkQuery = "SELECT userid FROM tblposts WHERE postid = $postid";
        $checkResult = $link->query($checkQuery);

        if ($checkResult && $checkResult->num_rows > 0) {
            $checkRow = $checkResult->fetch_array(MYSQLI_ASSOC);
            if ($checkRow['userid'] == $memid) {
                $updateQuery = "UPDATE tblposts SET postcontents = '$postContent' WHERE postid = $postid";
                if ($link->query($updateQuery)) {
                    $success = "Post updated successfully!";
                } else {
                    $error = "Failed to update post: " . $link->error;
                }
            } else {
                $error = "You don't have permission to edit this post!";
            }
        } else {
            $error = "Post not found!";
        }
    }
}

// Submit post
if (isset($_POST["submitPost"])) {

    if (!isset($_POST["postContent"]) || trim($_POST["postContent"]) == "") {
        $error .= "Enter Contents......";
    }

    if ($error == "") {
        $memid = (int)$_SESSION["memid"];
        $lastID = NULL;

        // File upload block
        if (isset($_FILES["userFile"]) && $_FILES["userFile"]["error"] == 0 && $_FILES["userFile"]["size"] > 0) {
            $baseValue = dirname(__FILE__);
            $upFilePath = "/posts/files";
            $myFileFeild = "userFile";

            include("includes/upload-picture.php");

            if (isset($fileErrors) && $fileErrors == 0 && isset($filename) && $filename != '') {
                $filename_escaped = $link->real_escape_string($filename);
                $sqlFile = "INSERT INTO tblfiles (filename, userid) VALUES ('" . $filename_escaped . "', '" . $memid . "')";

                if ($link->query($sqlFile)) {
                    $lastID = $link->insert_id;
                } else {
                    $error .= "File database error: " . $link->error;
                }
            }
        }

        if ($error == "") {
            $postContent = $link->real_escape_string(trim($_POST["postContent"]));

            if ($lastID) {
                $sqlPost = "INSERT INTO tblposts (postcontents, userid, fileid, date) 
                            VALUES ('" . $postContent . "', '" . $memid . "', '" . $lastID . "', '" . date("D, d M Y") . "')";
            } else {
                $sqlPost = "INSERT INTO tblposts (postcontents, userid, fileid, date) 
                            VALUES ('" . $postContent . "', '" . $memid . "', NULL, '" . date("D, d M Y") . "')";
            }

            if ($link->query($sqlPost)) {
                header("Location: front.php");
                exit();
            } else {
                $error .= "Post save error: " . $link->error;
            }
        }
    }
}
?>

<div class="pgSize">
    <p class="allFIles"><a href="files.php">📂 All Files</a></p>

    <?php 
    if ($error != "") {
        echo "<div class='alert alert-error'>" . $error . "</div>";
    }
    if ($success != "") {
        echo "<div class='alert alert-success'>" . $success . "</div>";
    }
    ?>

    <div class="postForm">
        <form method="post" action="" enctype="multipart/form-data">
            <textarea name="postContent" id="postTextarea" placeholder="What's on your mind, <?php echo $_SESSION['firstName']; ?>?" rows="3"></textarea>

            <div class="post-controls-bottom">
                <div id="filePreviewContainer" style="display: none;">
                    <span id="fileNameDisplay" class="file-tag"></span>
                    <button type="button" id="clearFile" class="clear-file-btn" title="Remove File">✕</button>
                </div>
                <span id="charCount" class="char-count">0/500</span>
            </div>
            <div class="divider"></div>

            <div class="tools">
                <div class="tools-left">
                    <label for="fileUpload" class="file-upload-btn" title="Upload Photo/File">
                        <span>📂</span>
                        <span class="btn-text">Choose File</span>
                    </label>
                    <input type="file" id="fileUpload" name="userFile" class="hidden-input" accept="image/*,video/*,.pdf,.doc,.docx,.xls,.xlsx, .xlxs">

                    <button type="button" class="file-upload-btn link-btn" title="Add Link">
                        <span>🔗</span>
                        <span class="btn-text">Link</span>
                    </button>
                </div>

                <input type="submit" name="submitPost" value="Post" class="btn-post" id="submitPostBtn" disabled>
            </div>
        </form>
    </div>

    <div id="emojiPicker" class="emoji-picker" style="display: none;">
        <div class="emoji-header">
            <span>Select Emoji</span>
            <button type="button" class="close-emoji">✕</button>
        </div>
        <div class="emoji-grid">
            😀 😃 😄 😁 😆 😅 🤣 😂 🙂 🙃 😉 😊 😇 🥰 😍 🤩 😘 😗 😚 😙
            😋 😛 😜 🤪 😝 🤑 🤗 🤭 🤫 🤔 🤐 🤨 😐 😑 😶 😏 😒 🙄 😬 🤥
            😌 😔 😪 🤤 😴 😷 🤒 🤕 🤢 🤮 🤧 🥵 🥶 🥴 😵 🤯 🤠 🥳 😎 🤓
            👍 👎 👌 ✌️ 🤞 🤟 🤘 🤙 👈 👉 👆 👇 ☝️ ✋ 🤚 🖐 🖖 👋 🤝 💪
            ❤️ 🧡 💛 💚 💙 💜 🖤 🤍 🤎 💔 ❣️ 💕 💞 💓 💗 💖 💘 💝 💟 ✨
            ⭐ 🌟 💫 💥 🔥 💯 ✅ ❌ ⚠️ 🎉 🎊 🎈 🎁 🏆 🥇 🥈 🥉 🏅 🎯 🎮
        </div>
    </div>

    <div id="linkPopup" class="link-popup" style="display: none;">
        <div class="popup-content">
            <div class="popup-header">
                <span>Insert Link</span>
                <button type="button" class="close-link">✕</button>
            </div>
            <input type="url" id="linkInput" placeholder="Enter URL (e.g., https://example.com)" class="link-input">
            <button type="button" id="insertLink" class="btn-insert-link">Insert</button>
        </div>
    </div>

    <div class="postArea">
        <?php
        $query = "SELECT * FROM tblposts ORDER BY postid DESC";
        $result = $link->query($query);

        if ($result && $result->num_rows > 0) {

            while ($rows = $result->fetch_array(MYSQLI_ASSOC)) {

                $postid       = $rows["postid"] ?? 0;
                $postContents = $rows["postcontents"] ?? "";
                $postDate     = $rows["date"] ?? "";
                $userid       = isset($rows["userid"]) ? (int)$rows["userid"] : 0;
                $fileid       = isset($rows["fileid"]) ? (int)$rows["fileid"] : 0;

                $memberFirst = "Unknown";
                $memberLast  = "";
                $memberPic   = null;
                $memberUser  = null;

                if ($userid > 0) {
                    $queryInner = "SELECT memberpicture, memberfirstname, memberlastname, memberusername 
                                     FROM tblmembers WHERE memberid=" . $userid;
                    $resultInner = $link->query($queryInner);

                    if ($resultInner && $resultInner->num_rows > 0) {
                        $rowsInner = $resultInner->fetch_array(MYSQLI_ASSOC);
                        $memberPic  = $rowsInner["memberpicture"] ?? null;
                        $memberUser = $rowsInner["memberusername"] ?? null;
                        $memberFirst = $rowsInner["memberfirstname"] ?? "Unknown";
                        $memberLast  = $rowsInner["memberlastname"] ?? "";
                    }
                }

                $img = '';
                $fileName = '';

                if ($fileid > 0) {
                    $queryfiles = "SELECT filename FROM tblfiles WHERE fileid=" . $fileid;
                    $resultfiles = $link->query($queryfiles);

                    if ($resultfiles && $resultfiles->num_rows > 0) {
                        $rowsFiles = $resultfiles->fetch_array(MYSQLI_ASSOC);
                        $fileName = $rowsFiles["filename"] ?? "";

                        if ($fileName != '') {
                            $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                            if (in_array($ext, ["jpg", "jpeg", "png", "gif", "webp"])) {
                                $img = '<img class="post-image" src="' . $localPath . '/posts/files/' . $fileName . '" />';
                            } else {
                                $iconMap = [
                                    'pdf'  => 'pdf',
                                    'doc'  => 'doc',
                                    'docx' => 'doc',
                                    'xls'  => 'xls',
                                    'xlsx' => 'xlxs',
                                    'zip'  => 'zip',
                                    'rar'  => 'zip',
                                    'mp3'  => 'mp3',
                                    'wav'  => 'audio',
                                    'mp4'  => 'mp4',
                                    'pptx'  => 'pptx',
                                    'mov'  => 'video'
                                ];

                                $iconName = isset($iconMap[$ext]) ? $iconMap[$ext] : 'file';
                                $iconPath = $localPath . "/images/files-icons/" . $iconName . ".jpg";

                                $img = '<a href="' . $localPath . '/posts/files/' . $fileName . '" target="_blank" class="file-icon-link">
                                    <img src="' . $iconPath . '" alt="' . $ext . ' file" style="width:50px; height:auto;" />
                                </a>';
                            }
                        }
                    }
                }

                $isOwner = ($userid == $_SESSION["memid"]);

                echo '
    <div class="post" data-postid="' . $postid . '">
        <div class="postHeader">
            ' . memberPicture($memberPic, $memberUser) . '
            <div class="userInfo">
                <h4>' . htmlspecialchars($memberFirst . ' ' . $memberLast) . '</h4>
                <span class="date">' . htmlspecialchars($postDate) . '</span>
            </div>';

                if ($isOwner) {
                    echo '
            <div class="postMenu">
                <span class="dots" title="Post Options">⋯</span>
                <div class="menu-dropdown">
                    <a href="#" class="edit-post" data-postid="' . $postid . '">✏️ Edit Post</a>
                    <a href="?delete=1&postid=' . $postid . '" class="delete" onclick="return confirm(\'Are you sure you want to delete this post?\')">🗑️ Delete Post</a>
                </div>
            </div>';
                }

                echo '
        </div>
        
        <div class="postContent" data-content="' . htmlspecialchars($postContents) . '">' . nl2br(htmlspecialchars($postContents)) . '</div>';

                if ($fileName != '') {
                    echo '
        <div class="postAttachment">
            <div class="file-preview">
                ' . $img . '
                <span class="file-name">' . htmlspecialchars($fileName) . '</span>
            </div>
        </div>';
                }

                echo '
    </div>';
            }
        } else {
            echo '<p class="noPost">No posts yet. Be the first to share something!</p>';
        }
        ?>
    </div>
</div>

<div id="editModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Edit Post</h3>
            <button type="button" class="close-modal">✕</button>
        </div>
        <form method="post" action="" id="editPostForm">
            <input type="hidden" name="postid" id="editPostId">
            <textarea name="editPostContent" id="editPostContent" rows="5" required></textarea>
            <div class="modal-actions">
                <button type="button" class="btn-cancel">Cancel</button>
                <button type="submit" name="editPost" class="btn-save">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<style>
.alert {
    padding: 12px 20px;
    margin: 15px 0;
    border-radius: 8px;
    font-size: 14px;
}
.alert-error {
    background-color: #fee;
    color: #c33;
    border-left: 4px solid #c33;
}
.alert-success {
    background-color: #efe;
    color: #3c3;
    border-left: 4px solid #3c3;
}
</style>

<script>
    const postTextarea = document.getElementById('postTextarea');
    const submitPostBtn = document.getElementById('submitPostBtn');
    const charCount = document.getElementById('charCount');
    const fileUploadInput = document.getElementById('fileUpload');
    const filePreviewContainer = document.getElementById('filePreviewContainer');
    const fileNameDisplay = document.getElementById('fileNameDisplay');
    const clearFileBtn = document.getElementById('clearFile');
    const MAX_CHARS = 500;

    function updatePostFormState() {
        const content = postTextarea.value.trim();
        const content_length = content.length;

        charCount.textContent = `${content_length}/${MAX_CHARS}`;
        charCount.style.color = content_length > MAX_CHARS ? 'var(--danger)' : 'var(--text-secondary)';

        if (content_length > 0 && content_length <= MAX_CHARS) {
            submitPostBtn.removeAttribute('disabled');
        } else {
            submitPostBtn.setAttribute('disabled', 'disabled');
        }
    }

    updatePostFormState();
    postTextarea.addEventListener('input', updatePostFormState);

    fileUploadInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const fileName = this.files[0].name;
            fileNameDisplay.textContent = fileName;
            filePreviewContainer.style.display = 'flex';
        } else {
            filePreviewContainer.style.display = 'none';
            fileNameDisplay.textContent = '';
        }
    });

    clearFileBtn.addEventListener('click', function() {
        fileUploadInput.value = '';
        filePreviewContainer.style.display = 'none';
        fileNameDisplay.textContent = '';
    });

    // Post Menu Toggle
    document.querySelectorAll('.postMenu').forEach(menu => {
        const dots = menu.querySelector('.dots');
        const dropdown = menu.querySelector('.menu-dropdown');

        dots.addEventListener('click', function(e) {
            e.stopPropagation();
            document.querySelectorAll('.menu-dropdown.show').forEach(openMenu => {
                if (openMenu !== dropdown) {
                    openMenu.classList.remove('show');
                }
            });
            dropdown.classList.toggle('show');
        });
    });

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.postMenu')) {
            document.querySelectorAll('.menu-dropdown.show').forEach(dropdown => {
                dropdown.classList.remove('show');
            });
        }
    });

    // Emoji Picker
    document.querySelector('.emoji-btn')?.addEventListener('click', function() {
        document.getElementById('emojiPicker').style.display = 'block';
    });

    document.querySelector('.close-emoji')?.addEventListener('click', function() {
        document.getElementById('emojiPicker').style.display = 'none';
    });

    document.querySelector('.emoji-grid')?.addEventListener('click', function(e) {
        if (e.target.textContent.trim()) {
            postTextarea.value += e.target.textContent;
            document.getElementById('emojiPicker').style.display = 'none';
            postTextarea.focus();
            updatePostFormState();
        }
    });

    // Link Popup
    document.querySelector('.link-btn')?.addEventListener('click', function() {
        document.getElementById('linkPopup').style.display = 'flex';
    });

    document.querySelector('.close-link')?.addEventListener('click', function() {
        document.getElementById('linkPopup').style.display = 'none';
    });

    document.getElementById('insertLink')?.addEventListener('click', function() {
        const link = document.getElementById('linkInput').value;
        if (link) {
            postTextarea.value += '\n' + link;
            document.getElementById('linkPopup').style.display = 'none';
            document.getElementById('linkInput').value = '';
            postTextarea.focus();
            updatePostFormState();
        }
    });

    // FIXED: Edit Post Modal
    const editModal = document.getElementById('editModal');
    const editPostForm = document.getElementById('editPostForm');
    const editPostContent = document.getElementById('editPostContent');

    document.querySelectorAll('.edit-post').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const postId = this.dataset.postid;
            const post = document.querySelector(`.post[data-postid="${postId}"]`);
            const content = post.querySelector('.postContent').dataset.content;

            document.getElementById('editPostId').value = postId;
            editPostContent.value = content;
            editModal.style.display = 'flex';

            // Close the dropdown menu
            const dropdown = this.closest('.menu-dropdown');
            if (dropdown) {
                dropdown.classList.remove('show');
            }
        });
    });

    function closeEditModal() {
        editModal.style.display = 'none';
        editPostContent.value = '';
    }

    document.querySelector('.close-modal')?.addEventListener('click', closeEditModal);
    document.querySelector('.btn-cancel')?.addEventListener('click', closeEditModal);

    // Close modal when clicking outside
    editModal.addEventListener('click', function(e) {
        if (e.target === editModal) {
            closeEditModal();
        }
    });

    // Auto-dismiss success/error messages after 5 seconds
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        });
    }, 5000);
</script>

<?php include("includes/footer.php"); ?>