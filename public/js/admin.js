// Xử lý sự kiện khi trang được tải
document.addEventListener('DOMContentLoaded', function() {
    // Xử lý nút thêm dòng câu hỏi mới
    const addNewQuestionBtn = document.getElementById('addNewQuestion');
    if (addNewQuestionBtn) {
        let questionCount = 1;
        
        // Xóa các event listener cũ nếu có
        const newBtn = addNewQuestionBtn.cloneNode(true);
        addNewQuestionBtn.parentNode.replaceChild(newBtn, addNewQuestionBtn);
        
        newBtn.addEventListener('click', function() {
            const tbody = document.querySelector('#newQuestionsTable tbody');
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>${questionCount + 1}</td>
                <td><textarea class="form-control" name="new_questions[${questionCount}][question_text]" rows="2" required></textarea></td>
                <td><input type="text" class="form-control" name="new_questions[${questionCount}][option_a]" required></td>
                <td><input type="text" class="form-control" name="new_questions[${questionCount}][option_b]" required></td>
                <td><input type="text" class="form-control" name="new_questions[${questionCount}][option_c]" required></td>
                <td><input type="text" class="form-control" name="new_questions[${questionCount}][option_d]" required></td>
                <td>
                    <select class="form-select" name="new_questions[${questionCount}][correct_answer]" required>
                        <option value="">Chọn</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                    </select>
                </td>
                <td>
                    <select class="form-select" name="new_questions[${questionCount}][difficulty_level]" required>
                        <option value="">Chọn</option>
                        <option value="easy">Dễ</option>
                        <option value="medium">Trung Bình</option>
                        <option value="hard">Khó</option>
                    </select>
                </td>
                <td><textarea class="form-control" name="new_questions[${questionCount}][explanation]" rows="2"></textarea></td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm delete-row">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(newRow);
            questionCount++;
        });
    }

    // Xử lý nút xóa dòng
    document.addEventListener('click', function(e) {
        if (e.target.closest('.delete-row')) {
            if (confirm('Bạn có chắc chắn muốn xóa dòng này?')) {
                e.target.closest('tr').remove();
            }
        }
    });

    // Xử lý checkbox chọn tất cả
    const selectAllCheckbox = document.getElementById('select-all');
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            const checkboxes = document.getElementsByName('existing_questions[]');
            for (let checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        });
    }

    // Xử lý form submit
    const examForm = document.getElementById('examForm');
    if (examForm) {
        examForm.addEventListener('submit', function(e) {
            const newQuestions = document.querySelectorAll('#newQuestionsTable tbody tr');
            const existingQuestions = document.querySelectorAll('input[name="existing_questions[]"]:checked');
            
            if (newQuestions.length === 0 && existingQuestions.length === 0) {
                e.preventDefault();
                alert('Vui lòng thêm ít nhất một câu hỏi mới hoặc chọn câu hỏi đã có.');
                return;
            }
        });
    }
}); 